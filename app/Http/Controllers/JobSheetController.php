<?php

namespace App\Http\Controllers;

use App\Models\BreakingMaster;
use App\Models\CorrugationMaster;
use App\Models\DyeMaster;
use App\Models\LaminationMaster;
use App\Models\PastingDetail;
use App\Models\PastingMaster;
use App\Models\ShipperJobSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TRNDTL;
use App\Models\ErpParam;
use App\Models\Custom;
use App\Models\ItemMaster;
use App\Models\AccountMaster;
use App\Models\JobDetail;
use App\Models\Solna;
use App\Models\Lamination;
use App\Models\DyeJob;
use App\Models\ProcessSection;
use App\Models\Employee;
use App\Models\LaminationDetail;
use App\Models\DepartmentSection;
use App\Models\PasteSection;
use App\Models\PurchaseDetail;
use App\Models\DyeDetail;
use App\Models\Corrugation;
use App\Models\Breaking;
use App\Models\BreakingDetail;
use App\Models\CorrugationDetail;
use App\Models\ProductMaster;
use App\Models\SolnasMaster;
use App\Models\ShipperPurchases;
use App\Models\CorrugationPurchase;
use App\Models\DyeHelper;
use App\Models\DyeJobSheet;
use App\Models\DyePurchase;
use App\Models\FinishedProduct;
use App\Models\GlueJobSheet;
use App\Models\GluePurchase;
use App\Models\InkJobSheet;
use App\Models\SolnaMachine;
use App\Models\SolnasHelperDetail;
use App\Models\SolnasManDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\InkPurchase;
use App\Models\LaminationJobSheet;
use App\Models\LaminationPurchase;
use App\Models\PlateJobSheet;
use App\Models\PurchasePlate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class JobSheetController extends Controller
{
    public function index(Request $request)
    {
        $loggedInUser = Auth::user();
        $items = ItemMaster::all();
        $processSections = ProcessSection::all();
        $departmentSections = DepartmentSection::all();
        // dd($departmentSections);
        $productMasters = ProductMaster::where('status','active')->get();
        $employeeNames = Employee::all();

        $employeeTypes = DB::table('employee_type_detail')->get();
        $employeeProcess = DB::table('employee_processes')->get();

        $productMasters2 = DB::table('product_master')
            ->join('account_masters', 'product_master.aid', '=', 'account_masters.id')
            ->select('product_master.aid', 'account_masters.title')
            ->get()
            ->unique('title');

        $accountSuppliers = AccountMaster::all();
        $erpParams = ErpParam::with('level2')->get();

        // Get next v_no - max existing + 1 (or 1 if no records)
        $nextVNo = (DB::table('job_details')->max('v_no') ?? 0) + 1;

        // In your controller where you get $boxboardData
       $boxboardData = DB::table('boxboard_views as b')
    ->select(
        'b.item_id as item_id',
        'i.item_code as item_code',  // from item_masters
        'b.width as width',
        'b.lenght as length',
        'b.remain_qty as remain_qty'
    )
    ->join('item_masters as i', 'b.item_id', '=', 'i.id') // assuming i.id = item_id
    ->get();
        // dd($boxboardData);



        // Explicitly pass all variables to the view
        return view('job_sheet.list', [
            'loggedInUser' => $loggedInUser,
            'items' => $items,
            'processSections' => $processSections,
            'departmentSections' => $departmentSections,
            'productMasters' => $productMasters,
            'employeeNames' => $employeeNames,
            'employeeTypes' => $employeeTypes,
            'employeeProcess' => $employeeProcess,
            'productMasters2' => $productMasters2,
            'accountSuppliers' => $accountSuppliers,
            'erpParams' => $erpParams,
            'boxboardData' => $boxboardData,
            'nextVNo' => $nextVNo, // Our important variable
            'accountMasters' => collect(), // Initialize empty collection
            'purchaseAccount' => null,
        ]);
    }

    public function getinkDetails($item_id)
    {
        $ink = DB::table('ink_view')
            ->select('item', 'remain_qty', 'item_code')
            ->where('item_code', $item_id)
            ->first();

        return response()->json($ink);
    }

    public function getLaminationDetails(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'size' => 'required|string'
        ]);

        try {
            $stock = DB::table('lamination_view') // Replace with your actual table
                ->where('item_id', $request->item_id)
                ->where('size', $request->size)
                ->first();

            return response()->json([
                'remain_qty' => $stock ? $stock->remain_qty : 0,
                'size' => $stock ? $stock->size : 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch stock details',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getglueDetails($item_id)
    {
        $glue = DB::table('glue_view')
            ->select('item', 'remain_qty', 'item_code')
            ->where('item_code', $item_id)
            ->first();

        return response()->json($glue);
    }

    public function getshipperDetails($item_id)
    {
        $shipper = DB::table('shipper_view')
            ->select('item', 'remain_qty', 'item_code')
            ->where('item_code', $item_id)
            ->first();

        return response()->json($shipper);
    }

    public function editas($v_no)
    {

        $jobDetails = JobDetail::where('v_no', $v_no)->get();
        $currentJobDetail = $jobDetails->first();
        // Fetch the related product (if any)
        $product = null;
        if ($currentJobDetail && $currentJobDetail->product_id) {
            $product = ProductMaster::find($currentJobDetail->product_id);
        }
        $solnas = Solna::where('v_no', $v_no)->get();
        $laminations = Lamination::where('v_no', $v_no)->get();

        $dyes = DyeJob::where('v_no', $v_no)->get();
        $breakings = Breaking::where('v_no', $v_no)
            ->get();

        $corrugations = Corrugation::where('v_no', $v_no)->get();

        $departments = DB::table('employee_type_details')->pluck('department_name', 'department_id');
        $designations = DB::table('employee_type_details')->pluck('designation_name', 'designation_id');
        $employees = DB::table('employee_type_details')->pluck('employee_name', 'cnic_no');

        // If no records found, redirect back with an error message
        if ($jobDetails->isEmpty()) {
            return back()->with('error', "No job details found for V No {$v_no}");
        }

        $itemMasters = ItemMaster::all();
        $accountMasters = AccountMaster::all();
        $processSections = ProcessSection::all();
        $loggedInUser = Auth::user();
        $productMasters2 = DB::table('product_master')
            ->join('account_masters', 'product_master.aid', '=', 'account_masters.id')
            ->select('product_master.aid', 'account_masters.title')
            ->get()
            ->unique('title');

        $boxboardData = DB::table('boxboard_view')
            ->select('item_id', 'item_code', 'width', 'length', 'remain_qty')
            ->get();

        $inkData = DB::table('ink_view')
            ->select('item', 'remain_qty', 'item_code')
            ->get();

        $glueData = DB::table('glue_view')
            ->select('item', 'remain_qty', 'item_code')
            ->get();

        $shipperData = DB::table('shipper_view')
            ->select('item', 'remain_qty', 'item_code')
            ->get();

        $laminationData = DB::table('lamination_view')
            ->select('total_qty', 'remain_qty', 'item_id', 'size', 'item_name')
            ->get();

        $boxMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name')
            ->get();

        $solnaMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();

        $dyeMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();

        $laminationMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();
        // dd($laminationMachine);

        $corrugationMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();


        $employeeTypes = DB::table('employee_type_details')->get();
        $employeeProcess = DB::table('employee_processes')->get();

        $employeeTypeBox = DB::table('employee_type_details')
            ->where('department_id', 21)
            ->select('cnic_no', 'employee_name', 'department_name')
            ->orderBy('employee_name')
            ->get();
        $employeePastingBox = DB::table('employee_type_details')
            ->whereIn('department_id', [18, 19])
            ->select('cnic_no', 'employee_name', 'department_name', 'department_id')
            ->orderBy('employee_name')
            ->get();
        $employeeCorrugationBox = DB::table('employee_type_details')
            ->whereIn('department_id', [13])
            ->select('cnic_no', 'employee_name', 'department_name', 'department_id')
            ->orderBy('employee_name')
            ->get();


        $employeeTypeSolna = DB::table('employee_type_details')
            ->whereIn('department_id', [23, 25, 26, 29])
            ->where('designation_id', 7)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();

        $employeeTypeSolnaHelper = DB::table('employee_type_details')
            ->whereIn('department_id', [23, 25, 26, 29])
            ->where('designation_id', 8)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();

        $employeeTypedye = DB::table('employee_type_details')
            ->whereIn('department_id', [28, 31])
            ->where('designation_id', 7)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();


        $employeeTypedyeHelper = DB::table('employee_type_details')
            ->whereIn('department_id', [28, 31])
            ->where('designation_id', 8)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();


        $employeeTypeLamination = DB::table('employee_type_details')
            ->whereIn('department_id', [22, 33])
            ->where('designation_id', 7)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();
        // dd($employeeTypeLamination);
        $employeeTypebreaking = DB::table('employee_type_details')
            ->whereIn('department_id', [20])
            ->where('designation_id', 10)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();

        $SolnaMans = SolnasManDetail::where('v_no', $v_no)->get();
        if ($SolnaMans->isEmpty()) {
            $SolnaMans = collect(); // empty collection
        }

        $SolnaHelpers = SolnasHelperDetail::where('v_no', $v_no)->get();
        if ($SolnaHelpers->isEmpty()) {
            $SolnaHelpers = collect(); // empty collection
        }

        $SolnaMaster = SolnasMaster::where('v_no', $v_no)->first();
        if (!$SolnaMaster) {
            $SolnaMaster = null; // or (object)[] if you want an empty object
        }

        $inkItemsQty = InkPurchase::with('items')->select('item_code')->distinct()->get();
        $dyeItemsQty = DyePurchase::with('items')->select('item_code')->distinct()->get();
        // dd($dyeItemsQty);
        $plateItemsQty = PurchasePlate::with('items')->select('item_code')->distinct()->get();
        $laminationItemsQty = LaminationPurchase::with('item')
            ->select('item_id', 'size')
            ->distinct()
            ->get();

        $glueItemsQty = GluePurchase::with('items')->select('item_code')->distinct()->get();
        // dd($glueItemsQty);

        if ($SolnaMaster) {
            $solnaInk = InkJobSheet::where('v_no', $v_no)->where('department_id', $SolnaMaster->id)->get();
            $solnaPlate = PlateJobSheet::where('v_no', $v_no)->where('department_id', $SolnaMaster->id)->get();
        } else {
            $solnaInk = collect();
            $solnaPlate = collect();
        }



        $laminationRecord = LaminationMaster::where('v_no', $v_no)->first();
        $laminationdetail = LaminationDetail::where('v_no', $v_no)->get();

        $dyeRecord = DyeMaster::where('v_no', $v_no)->first();
        $dyedetail = DyeDetail::where('v_no', $v_no)->get();
        $dyehelper = DyeHelper::where('v_no', $v_no)->get();

        if ($laminationRecord) {
            $laminationGlue = GlueJobSheet::where('v_no', $v_no)->where('department_id', $laminationRecord->department_id)->get();
            // dd($laminationGlue);
            $laminationItems = LaminationJobSheet::where('v_no', $v_no)->where('department_id', $laminationRecord->department_id)->get();
            // Debug
        } else {
            $laminationGlue = collect();
            $laminationItems = collect();
        }
        if ($dyeRecord) {
            $dyeItems = DyeJobSheet::where('v_no', $v_no)->where('department_id', $dyeRecord->department_id)->get();
        } else {
            $dyeItems = collect();
        }


        $breakingrecord = BreakingMaster::where('v_no', $v_no)->first();
        if ($breakingrecord) {
            $breakingdetail = BreakingDetail::where('v_no', $v_no)->get();
        } else {
            $breakingrecord = null;
            $breakingdetail = collect();
        }

        $pastingGlue = GlueJobSheet::where('v_no', $v_no)
            ->whereIn('department_id', [18, 19])
            ->get();
        $pastingMaster = PastingMaster::where('v_no', $v_no)
            ->whereIn('department_id', [18, 19])
            ->first();
        if ($pastingMaster) {
            $pastingDetail = PastingDetail::where('v_no', $v_no)
                ->where('department_id', $pastingMaster->department_id)
                ->get();
        } else {
            $pastingDetail = collect();
        }
        $corrugations = GlueJobSheet::where('v_no', $v_no)
            ->whereIn('department_id', [13])
            ->get();
        $corrugationMaster = CorrugationMaster::where('v_no', $v_no)

            ->first();
        if ($corrugationMaster) {
            $corrugationDetail = CorrugationDetail::where('v_no', $v_no)
                ->get();
        } else {
            $corrugationDetail = collect();
        }
        $finishedProduct = FinishedProduct::where('v_no', $v_no)->get();
        $shipperItemsQty = ShipperPurchases::with('items')->select('item_code')->distinct()->get();
        $shipperjob = ShipperJobSheet::where('v_no', $v_no)->get();
        return view('job_sheet.edit', compact(
            'jobDetails','shipperItemsQty','shipperjob',
            'laminationItemsQty',
            'breakingrecord',
            'finishedProduct',
            'breakingdetail',
            'corrugations',
            'corrugationMaster',
            'corrugationDetail',
            'dyedetail',
            'pastingGlue',
            'pastingMaster',
            'pastingDetail',
            'dyeRecord',
            'dyehelper',
            'employeePastingBox',
            'glueItemsQty',
            'laminationRecord',
            'laminationdetail',
            'laminationItems',
            'laminationGlue',
            'solnaInk',
            'solnaPlate',
            'dyeItems',
            'plateItemsQty',
            'SolnaMans',
            'SolnaHelpers',
            'SolnaMaster',
            'dyeItemsQty',
            'currentJobDetail',
            'product',
            'dyeMachine',
            'employeeCorrugationBox',
            'shipperData',
            'employeeTypebreaking',
            'laminationData',
            'corrugations',
            'breakings',
            'laminationMachine',
            'inkItemsQty',
            'corrugationMachine',
            'solnaMachine',
            'glueData',
            'laminations',
            'employeeTypeLamination',
            'employeeTypedye',
            'employeeTypedyeHelper',
            'dyes',
            'inkData',
            'solnas',
            'employeeTypeSolnaHelper',
            'itemMasters',
            'employeeTypeSolna',
            'employeeTypeBox',
            'boxMachine',
            'accountMasters',
            'processSections',
            'loggedInUser',
            'productMasters2',
            'boxboardData',
            'employeeTypes',
            'employeeProcess',
            'departments',
            'designations',
            'employees'
        ));
    }


    public function getProductDetails(Request $request)
    {
        try {
            $product = ProductMaster::find($request->id);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            // Fetch item_code from item_masters using item_id from product_masters
            $itemCode = ItemMaster::where('id', $product->item_id)->value('item_code');

            // Calculate packet_size
            $packetSize = "L:{$product->length}, W:{$product->width}, G:{$product->grammage}";


            // Calculate product_qty (ups * packet_size)


            return response()->json([
                'item_id' => $product->item_id, // ID from product_masters
                'item_code' => $itemCode, // Item Code from item_masters
                'ups' => $product->ups,
                'lam_size' => $product->lam_size,
                'curr_size' => $product->curr_size,
                'uv' => $product->uv,
                'simple' => $product->simple,
                'spot' => $product->spot,
                'color_no' => $product->color_no,
                'descr' => $product->descr,
                'file_path' => $product->file_path,
                'packet_size' => $packetSize,

            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching product details: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function getProducts($customerId)
    {
        $products = DB::table('product_master')
            ->where('aid', $customerId)
            ->select('id', 'prod_name')
            ->groupBy('id', 'prod_name') // Add prod_name to GROUP BY
            ->get();

        return response()->json($products);
    }

    public function fetchRate(Request $request)
    {
        $custom = ProcessSection::find($request->id);

        if ($custom) {
            return response()->json([
                'success' => true,
                'rate' => $custom->rate,
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }




    public function store(Request $request)
    {


        $filteredBoxItems = [];
        foreach ($request->box_item as $index => $itemId) {
            if (!empty($itemId)) {
                $filteredBoxItems[] = [
                    'item' => $itemId,
                    'length' => $request->box_length[$index],
                    'width' => $request->box_width[$index],
                    'qty' => $request->box_qty[$index],
                ];
            }
        }

        $validated = $request->validate([
            'job_type' => 'required|string',
            'aid' => 'required|exists:account_masters,id',
            'account' => 'required|exists:product_master,id',
            'packets' => 'required|numeric',
            'delivery_date' => 'required|date',
            'department_name' => 'required|array',
            'department_name.*' => 'exists:employee_type_details,department_id',
            'designation_sup' => 'required|array',
            'employee_sup' => 'required|array',
            'batch_no' => 'sometimes|array',
            'batch_qty' => 'sometimes|array',
            'batch_qty.*' => 'numeric',
            'box_item' => 'required|array',
            'box_item.*' => 'required|numeric',
            'box_width' => 'required|array',
            'box_width.*' => 'required|numeric',
            'box_length' => 'required|array',
            'box_length.*' => 'required|numeric',
            'box_qty' => 'required|array',
            'box_qty.*' => 'numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $newVNo = (JobDetail::max('v_no') ?? 0) + 1;

            $baseData = [
                'v_no' => $newVNo,
                'prepared_by' => auth()->user()->name,
                'job_type' => $request->job_type,
                'job_status' => 'Pending',
                'aid' => $request->aid,
                'product_id' => $request->account,
                'packets' => $request->packets,
                'product_qty' => $request->product_qty,
                'delivery_date' => $request->delivery_date,
                'sum_batch_no' => $request->sum_batch_no,
                'custom_descr' => $request->custom_descr,
                'date' => $request->date,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $createdJobDetails = [];

            // Get counts for all data types
            // Counts number of Departments 
            $deptCount = count($request->department_name);



            $batchCount = max(
                count($request->batch_no ?? []),
                count($request->batch_qty ?? [])
            );

            $boxCount = count($request->box_item);

            // Determine how many records we need to create
            $maxCount = max($deptCount, $batchCount, $boxCount);

            for ($index = 0; $index < $maxCount; $index++) {
                $dept = $request->department_name[$index] ?? null;

                // departments: 13,18,19 trigger Corrugation
                if (in_array($dept, [13, 18, 19])) {
                    Corrugation::create([
                        'v_no'          => $newVNo,
                        'department_id' => $dept,
                        'po_order_qty'  => $request->batch_qty[$index] ?? 0,
                    ]);
                }

                if (in_array($dept, [23, 25, 26, 29])) {
                    SolnasMaster::create([
                        'v_no'          => $newVNo,
                        'department_id' => $dept,
                        'v_date' => $request->date,
                        'total_impression' => $request->no_of_cut[0] * $request->color_no * $request->packets
                    ]);
                }
                if (in_array($dept, [33, 22])) {
                    LaminationMaster::create([
                        'v_no'          => $newVNo,
                        'department_id' => $dept,
                        'v_date' => $request->date,
                        'lamination_job_sheet_impression' => $request->no_of_cut[0]  * $request->packets
                    ]);
                }
                if (in_array($dept, [20])) {
                    BreakingMaster::create([
                        'v_no'          => $newVNo,
                        'v_date' => $request->date,
                        'breaking_job_impression' => $request->no_of_cut[0]  * $request->packets,
                        'total_job_sheet_impression' => $request->no_of_cut[0]  * $request->packets,
                    ]);
                }
                if (in_array($dept, [18, 19])) {
                    PastingMaster::create([
                        'v_no'          => $newVNo,
                        'v_date' => $request->date,
                        'department_id' => $dept,
                        'pasting_total_impression' => $request->no_of_cut[0]  * $request->packets,
                        'total_job_sheet_impression' => $request->no_of_cut[0]  * $request->packets,
                    ]);
                }
                if (in_array($dept, [13])) {
                    CorrugationMaster::create([
                        'v_no'          => $newVNo,
                        'v_date' => $request->date,
                        'department_id' => $dept,
                        'corrugation_total_impression' => $request->no_of_cut[0]  * $request->packets,
                        'total_job_sheet_impression' => $request->no_of_cut[0]  * $request->packets,
                    ]);
                }
                if (in_array($dept, [31, 28])) {
                    DyeMaster::create([
                        'v_no'          => $newVNo,
                        'v_date' => $request->date,
                        'department_id' => $dept,
                        'dye_job_impression' => $request->no_of_cut[0]  * $request->packets,
                        'total_job_sheet_impression' => $request->no_of_cut[0]  * $request->packets,
                    ]);
                }


                $jobData = array_merge($baseData, [
                    'department_name' => $request->department_name[$index] ?? null,
                    'designation_sup' => $request->designation_sup[$index] ?? null,
                    'employee_sup' => $request->employee_sup[$index] ?? null,
                    'batch_no' => $request->batch_no[$index] ?? null,
                    'batch_qty' => $request->batch_qty[$index] ?? null,
                ]);

                // Add box item data if it exists at this index
                if (isset($request->box_item[$index])) {
                    $jobData['box_item'] = $request->box_item[$index];
                    $jobData['box_width'] = $request->box_width[$index];
                    $jobData['box_length'] = $request->box_length[$index];
                    $jobData['box_qty'] = $request->box_qty[$index];
                }

                // Special handling for Cutting department
                if (isset($request->department_name[$index]) && $request->department_name[$index] == 14) {
                    $jobData = array_merge($jobData, [
                        'length' => json_encode($request->length ?? []),
                        'width' =>  json_encode($request->width ?? []),
                        'no_of_cut' => json_encode($request->no_of_cut ?? []),
                        'department_Process' => json_encode($request->department_Process ?? []),
                    ]);
                }

                $jobDetail = JobDetail::create($jobData);
                $createdJobDetails[] = $jobDetail;
            }

            DB::commit();
            return redirect()->route('job.report')->with('success', 'Job sheet created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating job sheet: ' . $e->getMessage());
        }
    }

    public function report(Request $request)
    {
        $query = JobDetail::query()->orderBy('created_at', 'desc');

        // Apply filters (unchanged)
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('v_no') && $request->v_no) {
            $query->where('v_no', $request->v_no);
        }

        if ($request->has('aid') && $request->aid) {
            $query->where('aid', $request->aid);
        }

        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        $jobDetails = $query->get();
        $vehicleNumbers = JobDetail::select('v_no')->distinct()->pluck('v_no');

        // Get all unique IDs (unchanged)
        $customerIds = $jobDetails->pluck('aid')->unique()->filter()->values();
        $productIds = $jobDetails->pluck('product_id')->unique()->filter()->values();
        $departmentIds = $jobDetails->pluck('department_name')->unique()->filter()->values();
        $designationIds = $jobDetails->pluck('designation_sup')->unique()->filter()->values();
        $employeeCnicNos = $jobDetails->pluck('employee_sup')->unique()->filter()->values();

        // Get all unique box_item IDs
        $boxItemIds = $jobDetails->pluck('box_item')
            ->filter()
            ->unique()
            ->values();

        // Preload data (unchanged)
        $customers = DB::table('account_masters')
            ->whereIn('id', $customerIds)
            ->get()
            ->keyBy('id');

        $products = DB::table('product_master')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $employeeTypeDetails = DB::table('employee_type_details')
            ->whereIn('id', $departmentIds)
            ->orWhereIn('id', $designationIds)
            ->orWhereIn('cnic_no', $employeeCnicNos)
            ->get();

        // Create mappings (unchanged)
        $departmentMap = $employeeTypeDetails->pluck('department_name', 'department_id');
        $designationMap = $employeeTypeDetails->pluck('designation_name', 'designation_id');
        $employeeMap = $employeeTypeDetails->pluck('employee_name', 'cnic_no');

        $itemIds = collect($products)->pluck('item_id')->unique()->filter()->values();
        $items = DB::table('item_masters')
            ->whereIn('id', $itemIds)
            ->get()
            ->keyBy('id');

        // Load box items from item_masters
        $boxItems = DB::table('item_masters')
            ->whereIn('id', $boxItemIds)
            ->get()
            ->keyBy('id');

        $countryIds = collect($products)->pluck('country_id')->unique()->filter()->values();
        $countries = DB::table('countries')
            ->whereIn('id', $countryIds)
            ->get()
            ->keyBy('id');

        // Group job details by v_no with all related data
        $groupedJobDetails = $jobDetails->groupBy('v_no')->map(function ($group) use ($customers, $products, $items, $countries, $departmentMap, $designationMap, $employeeMap, $boxItems) {
            $firstItem = $group->first();

            $customer = $customers[$firstItem->aid] ?? null;
            $product = $products[$firstItem->product_id] ?? null;
            $item = $product && $product->item_id ? ($items[$product->item_id] ?? null) : null;
            $country = $product && $product->country_id ? ($countries[$product->country_id] ?? null) : null;

            // Get all unique departments, designations, and employees for this v_no
            $departments = $group->map(function ($item) use ($departmentMap) {
                return $departmentMap[$item->department_name] ?? $item->department_name ?? 'N/A';
            })->filter()->values()->all();

            $designations = $group->map(function ($item) use ($designationMap) {
                return $designationMap[$item->designation_sup] ?? $item->designation_sup ?? 'N/A';
            })->filter()->values()->all();

            $employees = $group->map(function ($item) use ($employeeMap) {
                return $employeeMap[$item->employee_sup] ?? $item->employee_sup ?? 'N/A';
            })->filter()->values()->all();

            $batchInfo = $group->map(function ($item) {
                return [
                    'batch_no' => $item->batch_no ?? 'N/A',
                    'batch_qty' => $item->batch_qty ?? 'N/A',
                    'job_status' => $item->job_status ?? 'N/A',
                ];
            })->all();

            $boxLengths = $group->pluck('box_length')->filter()->values()->all();
            $boxWidths = $group->pluck('box_width')->filter()->values()->all();
            $boxQtys = $group->pluck('box_qty')->filter()->values()->all();

            // Map box_item IDs to item_codes
            $boxItemCodes = $group->pluck('box_item')->map(function ($itemId) use ($boxItems) {
                return $itemId ? ($boxItems[$itemId]->item_code ?? $itemId) : null;
            })->filter()->values()->all();

            return [
                'v_no' => $firstItem->v_no,
                'prepared_by' => $firstItem->prepared_by ?? 'N/A',
                'job_type' => $firstItem->job_type ?? 'N/A',
                'aid' => $firstItem->aid,
                'product_id' => $firstItem->product_id,

                // Updated to arrays
                'departments' => $departments,
                'designations' => $designations,
                'employees' => $employees,

                'packets' => $firstItem->packets,
                'batch_info' => $batchInfo,
                'product_name' => $product->prod_name ?? 'N/A',
                'item_id' => $product->item_id ?? 'N/A',
                'item_code' => $item->item_code ?? 'N/A',
                'delivery_date' => $firstItem->delivery_date,
                'department_Process' => $firstItem->department_process ?? 'N/A',
                'length' => $firstItem->length,
                'width' => $firstItem->width,
                'no_of_cut' => $firstItem->no_of_cut,
                'custom_descr' => $firstItem->custom_descr ?? 'N/A',
                'job_status' => $firstItem->job_status ?? 'N/A',
                'account_title' => $customer->title ?? 'N/A',
                'created_at' => $firstItem->created_at,
                'product_length' => $product->length ?? 'N/A',
                'product_width' => $product->width ?? 'N/A',
                'product_grammage' => $product->grammage ?? 'N/A',
                'product_ups' => $product->ups ?? 'N/A',
                'product_color' => $product->color_no ?? 'N/A',
                'product_country' => $country->country_name ?? 'N/A',
                'product_country_id' => $product->country_id ?? 'N/A',
                'product_lam_size' => $product->lam_size ?? 'N/A',
                'product_curr_size' => $product->curr_size ?? 'N/A',
                'product_simple' => $product->simple ?? 'N/A',
                'product_spot' => $product->spot ?? 'N/A',
                'product_description' => $product->descr ?? 'N/A',
                'product_img' => $product->file_path ?? 'N/A',

                'box_length' => $boxLengths,
                'box_width' => $boxWidths,
                'box_qty' => $boxQtys,
                'box_item' => $boxItemCodes, // Now contains item_codes instead of IDs
                'box_item_ids' => $group->pluck('box_item')->filter()->values()->all(), // Keep original IDs if needed
            ];
        });

        // Get unique customers and products for dropdowns (unchanged)
        $uniqueCustomers = $customers->pluck('title', 'id');
        $uniqueItems = $products->pluck('prod_name', 'id');

        return view('job_sheet.index', [
            'groupedJobDetails' => $groupedJobDetails,
            'vehicleNumbers' => $vehicleNumbers,
            'uniqueCustomers' => $uniqueCustomers,
            'uniqueItems' => $uniqueItems,
            'accountTitles' => $uniqueCustomers,
        ]);
    }


    public function destroy(Request $request)
    {
        // Validate the incoming request to ensure 'v_no' is present
        $request->validate([
            'v_no' => 'required|integer',
        ]);

        // Retrieve the 'v_no' from the request
        $vNo = $request->input('v_no');

        // Delete all records with the specified 'v_no'
        JobDetail::where('v_no', $vNo)->delete();
        Solna::where('v_no', $vNo)->delete();
        DyeJob::where('v_no', $vNo)->delete();
        Lamination::where('v_no', $vNo)->delete();

        // Redirect back with a success message
        return back()->with('success', "Job details with V No {$vNo} deleted successfully!");
    }


    public function update(Request $request, $v_no)
    {
        // dd(count($request->lamination_item));
        // dd($request->all());



        DB::beginTransaction();

        try {


            JobDetail::where('v_no', $v_no)
                ->where('department_name', 14)
                ->update([
                    'box_employee' => $request->box_employee,
                    'box_machine' => $request->box_machine,
                    'box_date_boxboard' => $request->box_date_boxboard,
                    'box_status' => $request->box_status,
                    'afterups' => $request->afterups,
                ]);
            $machineMan = count($request->solna_date_machine ?? []);
            $machine = count($request->solna_machine_helper ?? []);
            $solnaInk = count($request->solnas_qty ?? []);
            $solnaPlate = count($request->solna_plate_item ?? []);
            $dep = SolnasMaster::where('v_no', $v_no)->first();
            if ($dep) {
                $dep->update([

                    'total_helper_impression' => $request->helper_impression ?? 0,
                    'total_machine_impression' => $request->manual_impression ?? 0,
                    'total_impression' => $request->solna_job_sheet_impression ?? 0,
                    'department_id' => $dep->department_id,
                    'grand_total_impression' => $request->solna_total_job_sheet_impression ?? 0
                ]);
            }
            SolnasManDetail::where('v_no', $v_no)->delete();
            SolnasHelperDetail::where('v_no', $v_no)->delete();
            InkJobSheet::where('department_id', $dep->id)->delete();
            PlateJobSheet::where('department_id', $dep->id)->delete();
            for ($i = 0; $i < $solnaPlate; $i++) {

                PlateJobSheet::create([
                    'v_no' => $v_no,
                    'v_date' => $dep->v_date,
                    'department_id' => $dep->id,
                    'qty' => $request->solna_plate_qty[$i],
                    'item_id' => $request->solna_plate_item[$i],
                ]);
            }
            for ($i = 0; $i < $solnaInk; $i++) {

                InkJobSheet::create([
                    'v_no' => $v_no,
                    'v_date' => $dep->v_date,
                    'department_id' => $dep->id,
                    'qty' => $request->solnas_qty[$i],
                    'item_id' => $request->solnas_item[$i],
                ]);
            }
            for ($i = 0; $i < $machineMan; $i++) {

                SolnasManDetail::create([
                    'v_no' => $v_no,
                    'v_date' => $request->solna_date_machine[$i],
                    'given_impression' => $request->solna_man_impression[$i],
                    'total_wastage' => $request->solna_man_waste[$i],
                    'department_id' => $dep->department_id,
                    'machine_id' => $request->solna_machine[$i],
                    'man_id' => $request->solna_man[$i],
                ]);
            }
            for ($i = 0; $i < $machine; $i++) {

                SolnasHelperDetail::create([
                    'v_no' => $v_no,
                    'v_date' => $request->solna_date_helper[$i],
                    'given_impression' => $request->solna_helper_impression[$i],
                    'department_id' => $dep->department_id,
                    'machine_id' => $request->solna_machine_helper[$i],
                    'man_id' => $request->solna_helper[$i],
                ]);
            }
            $laminationDepartments = [22, 33];

            LaminationDetail::where('v_no', $v_no)
                ->whereIn('department_id', $laminationDepartments)
                ->delete();
            LaminationJobSheet::where('v_no', $v_no)
                ->whereIn('department_id', $laminationDepartments)
                ->delete();
            LaminationMaster::where('v_no', $v_no)
                ->whereIn('department_id', $laminationDepartments)
                ->delete();
            GlueJobSheet::where('v_no', $v_no)

                ->delete();


            $lamMan = $request->lamination_man ?? [];
            $lamMax = count($lamMan);
            $dep_id = null;
            for ($i = 0; $i < $lamMax; $i++) {

                if (!$lamMan[$i]) continue;

                [$cnic, $dept] = array_pad(explode('|', $lamMan[$i]), 2, null);
                if (!in_array((int)$dept, $laminationDepartments)) continue;

                LaminationDetail::create([
                    'department_id' => $dept,
                    'v_no' => $v_no,
                    'lamination_date' => $request->lamination_date_machine[$i] ?? null,
                    'lamination_man_id' => $cnic,
                    'lamination_machine_id' => $request->lamination_machine[$i] ?? null,
                    'lamination_given_impression' => $request->lamination_man_impression[$i] ?? null,
                    'lamination_waste_impression' => $request->lamination_man_waste[$i] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $dep_id = $dept;
            }

            if ($dep_id) {
                LaminationMaster::create([
                    'department_id' => $dep_id,
                    'v_no' => $v_no,
                    'lamination_job_sheet_impression' => $request->lamination_job_sheet_impression ?? null,
                    'lamination_total_job_sheet_impression' => $request->lamination_total_job_sheet_impression ?? null,
                    'lamination_status' => $request->lamination_status ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $glueJoblamination = count($request->lamination_glue ?? []);
                $lamJoblamination = count($request->lamination_item ?? []);

                for ($i = 0; $i < $glueJoblamination; $i++) {
                    GlueJobSheet::create([
                        'v_no' => $v_no,
                        'department_id' => $dep_id,
                        'v_date' => $request->date,
                        'item_id' => $request->lamination_glue[$i] ?? null,
                        'qty' => $request->lamination_glue_qty[$i] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                for ($i = 0; $i < $lamJoblamination; $i++) {
                    LaminationJobSheet::create([
                        'v_no' => $v_no,
                        'department_id' => $dep_id,
                        'v_date' => $request->date,
                        'item_id' => $request->lamination_item[$i] ?? null,
                        'qty' => $request->lamination_qty[$i] ?? null,
                        'size' => $request->size[$i] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DyeMaster::where('v_no', $v_no)->delete();
            DyeDetail::where('v_no', $v_no)->delete();
            DyeHelper::where('v_no', $v_no)->delete();
            DyeJobSheet::where('v_no', $v_no)->delete();
            $departmentsDye = [28, 31];
            $dyeDep = null;
                $counterDye = count($request->dye_machine ?? []);
                //Dye Man
                $counterDyeManer = count($request->dye_man ?? []);
                $counterDyeMan = $request->dye_man ?? [];
                //Dye Helper
                $counterDyeHelper = count($request->dye_helper ?? []);
                $counterDyeHelp = $request->dye_helper ?? [];

                for ($i = 0; $i < $counterDyeManer; $i++) {
                    if (!$counterDyeMan[$i]) continue;

                    [$cnic, $dept] = array_pad(explode('|', $counterDyeMan[$i]), 2, null);
                    if (!in_array((int)$dept, $departmentsDye)) continue;
                    DyeDetail::create([
                        'department_id' => $dept,
                        'v_no' => $v_no,
                        'dye_date' => $request->dye_date_machine[$i] ?? null,
                        'dye_man_id' => $cnic,
                        'dye_machine_id' => $request->dye_machine[$i] ?? null,
                        'dye_given_impression' => $request->dye_man_impression[$i] ?? null,
                        'dye_waste_impression' => $request->dye_man_waste[$i] ?? null,
                    ]);
                    $dyeDep = $dept;
                }
                for ($i = 0; $i < $counterDyeHelper; $i++) {
                    DyeHelper::create([
                        'department_id' => $dyeDep,
                        'v_no' => $v_no,
                        'dye_date' => $request->dye_date_helper[$i] ?? null,
                        'dye_man_id' => $request->dye_helper[$i] ?? null,
                        'dye_machine_id' => $request->dye_machine_helper[$i] ?? null,
                        'dye_given_impression' => $request->dye_helper_impression[$i] ?? null,
                    ]);
                }
                if ($dyeDep) {
                    DyeMaster::create([
                        'department_id' => $dyeDep,
                        'v_no' => $v_no,
                        'dye_job_sheet_impression' => $request->dye_total_manual_impression ?? null,
                        'dye_total_job_sheet_impression' => $request->dye_total_job_sheet_impression ?? null,
                        'dye_status' => $request->dye_status ?? null,
                    ]);
                }
            
            $dyecountjob = count($request->dye_item ?? []);
            for ($i = 0; $i < $dyecountjob; $i++) {
                DyeJobSheet::create([
                    'v_no' => $v_no,
                    'department_id' => $dyeDep,
                    'item_id' => $request->dye_item[$i] ?? 0,
                    'qty' => $request->dye_qty[$i] ?? 0,
                    'v_date' => $request->date ?? now()
                ]);
            }

            BreakingMaster::where('v_no', $v_no)->delete();
            BreakingDetail::where('v_no', $v_no)->delete();

            $breakingCounter = count($request->breaking_contractor ?? []);
            $counterBreaker = $request->breaking_contractor ?? [];
            // dd([$cnic, $dept] = array_pad(explode('|', $counterBreaker[0]), 2, null));
            $breakdepId = null;
            for ($i = 0; $i < $breakingCounter; $i++) {
                if (!$counterBreaker[$i]) continue;

                [$cnic, $dept] = array_pad(explode('|', $counterBreaker[$i]), 2, null);
                if (!$dept) continue;

                $breakdepId = $dept;
                BreakingDetail::create([
                    'v_no' => $v_no,
                    'breaking_date' => $request->breaking_date_machine[$i] ?? null,
                    'breaking_man_id' => $cnic ?? null,
                    'breaking_impression' => $request->breaking_impression[$i] ?? null,
                    'breaking_waste' => $request->breaking_waste[$i] ?? null,
                ]);
            }
            if ($breakdepId) {
                BreakingMaster::create([
                    'v_no' => $v_no,
                    'breaking_job_impression' => $request->breaking_job_sheet_impression ?? null,
                    'total_job_sheet_impression' => $request->breaking_total_job_sheet_impression ?? null,
                    'breaking_status' => $request->breaking_status ?? null,
                    'breaking_total_impression' => $request->breaking_total_impression ?? null,
                    'breaking_total_waste' => $request->breaking_total_waste ?? null,
                ]);
            }

            //counter for Pasting Glue

            PastingMaster::where('v_no', $v_no)->delete();
            PastingDetail::where('v_no', $v_no)->delete();

            $counterPasting = count($request->pasting_glue ?? []);

            $counterPastingDetail = count($request->pasting_contractor ?? []);
            $depPasting = $request->pasting_contractor ?? null;
            $depPastingId = null;
            for ($i = 0; $i < $counterPastingDetail; $i++) {
                if (!$depPasting[$i]) continue;

                [$cnic, $dept] = array_pad(explode('|', $depPasting[$i]), 2, null);
                if (!$dept) continue;

                $depPastingId = $dept;
                PastingDetail::create([
                    'v_no' => $v_no,
                    'pasting_date' => $request->pasting_date_machine[$i] ?? $request->date ?? null,
                    'pasting_man_id' => $cnic ?? null,
                    'pasting_impression' => $request->pasting_impression[$i] ?? null,
                    'pasting_waste' => $request->pasting_waste[$i] ?? null,
                    'department_id' => $depPastingId
                ]);
            }
            if ($depPastingId) {
                PastingMaster::create([
                    'v_no' => $v_no,
                    'pasting_job_impression' => $request->pasting_job_sheet_impression ?? null,
                    'total_job_sheet_impression' => $request->pasting_total_job_sheet_impression ?? null,
                    'pasting_status' => $request->pasting_status ?? null,
                    'department_id' => $depPastingId,
                    'pasting_total_impression' => $request->pasting_total_impression ?? null,
                    'pasting_total_waste' => $request->pasting_total_waste ?? null,
                ]);
            }
            for ($i = 0; $i < $counterPasting; $i++) {
                GlueJobSheet::create([
                    'v_no' => $v_no,
                    'department_id' => $depPastingId,
                    'item_id' => $request->pasting_glue[$i] ?? null,
                    'qty' => $request->pasting_glue_qty[$i] ?? null,
                    'v_date' => $request->date ?? null
                ]);
            }
            $countshipper = count($request->shipper_qty ?? []);
            ShipperJobSheet::where('v_no', $v_no)->delete();
            for ($i = 0; $i < $countshipper; $i++) {
                ShipperJobSheet::create([
                    'v_no' => $v_no,
                    'item_id' => $request->shipper_item[$i] ?? null,
                    'qty' => $request->shipper_qty[$i] ?? null,
                    'v_date' => $request->date ?? null
                ]);
            }

            //corrugation
            //counter for Corrugation

            CorrugationMaster::where('v_no', $v_no)->delete();
            CorrugationDetail::where('v_no', $v_no)->delete();

            $counterCorrugation = count($request->corrugation_item ?? []);

            $counterCorrugationDetail = count($request->corrugation_contractor ?? []);
            $depCorrugation = $request->corrugation_contractor ?? null;
            $depCorrugationId = null;
            for ($i = 0; $i < $counterCorrugationDetail; $i++) {
                if (!$depCorrugation[$i]) continue;

                [$cnic, $dept] = array_pad(explode('|', $depCorrugation[$i]), 2, null);
                if (!$dept) continue;

                $depCorrugationId = $dept;
                CorrugationDetail::create([
                    'v_no' => $v_no,
                    'corrugation_date' => $request->corrugation_date_machine[$i] ?? $request->date ?? now(),
                    'corrugation_man_id' => $cnic ?? 0,
                    'corrugation_impression' => $request->corrugation_impression[$i] ?? 0,
                    'corrugation_waste' => $request->corrugation_waste[$i] ?? 0,
                    'department_id' => $depCorrugationId
                ]);
            }
            if ($depCorrugationId) {

                CorrugationMaster::create([

                    'v_no' => $v_no,
                    'corrugation_total_impression' => $request->corrugation_total_impression[$i] ?? 0,
                    'corrugation_total_waste' => $request->corrugation_total_waste[$i] ?? 0,
                    'total_job_sheet_impression' => $request->corrugation_total_job_sheet_impression ?? 0,
                    'corrugation_job_impression' => $request->corrugation_job_sheet_impression ?? 0,
                    'status' => $request->corrugation_status ?? 0
                ]);
            }



            for ($i = 0; $i < $counterCorrugation; $i++) {
                GlueJobSheet::create([
                    'v_no' => $v_no,
                    'department_id' => $depCorrugationId,
                    'item_id' => $request->corrugation_glue[$i] ?? null,
                    'qty' => $request->corrugation_qty[$i] ?? null,
                    'v_date' => $request->date ?? null
                ]);
            }

            $countFinishedProduct = count($request->f_box_size ?? []);
            FinishedProduct::where('v_no', $v_no)->delete();
            for ($i = 0; $i < $countFinishedProduct; $i++) {
                FinishedProduct::create([
                    'v_no' => $v_no,
                    'box_size' => $request->f_box_size[$i] ?? null,
                    'box_qty' => $request->f_box_qty[$i] ?? null,
                    'remaining_qty' => $request->f_remaining_qty[$i] ?? null,
                    'total_impression' => $request->f_total_impression[$i] ?? 0
                ]);
            }

            DB::commit();

            return redirect()
                ->route('job.report')
                ->with('success', "V No {$v_no} updated successfully");
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Update Failed', [
                'v_no' => $v_no,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Update failed, check logs.');
        }
    }

    /**
     * Process Solna data for departments 23, 25, 26, 29
     */
    private function processSolnaData(Request $request, string $v_no): void
    {
        // Process MACHINE MEN
        $this->processSolnaMen($request, $v_no);

        // Process HELPERS
        $this->processSolnaHelpers($request, $v_no);
    }

    /**
     * Process only Machine Men for Solna
     */
    private function processSolnaMen(Request $request, string $v_no): void
    {
        $dataArrays = [
            'solna_man' => $this->normalizeToArray($request->input('solna_man', [])),
            'solna_machine' => $this->normalizeToArray($request->input('solna_machine', [])),
            'solna_date_machine' => $this->normalizeToArray($request->input('solna_date_machine', [])),
            'solna_man_impression' => $this->normalizeToArray($request->input('solna_man_impression', [])),
            'solna_man_waste' => $this->normalizeToArray($request->input('solna_man_waste', [])),
            'ink_item' => $this->normalizeToArray($request->input('solna_ink', [])),
            'ink_qty' => $this->normalizeToArray($request->input('ink_qty', [])),
        ];

        // Find maximum count for men
        $maxCount = 0;
        foreach ($dataArrays as $array) {
            $maxCount = max($maxCount, count($array));
        }

        // Get departments from men
        $departments = [];
        foreach ($dataArrays['solna_man'] as $man) {
            [, $department] = $this->extractCnicAndDepartment($man);
            if ($department) {
                $departments[] = $department;
            }
        }

        // Delete existing man records
        if (!empty($departments)) {
            Solna::where('v_no', $v_no)
                ->whereIn('department_id', array_unique($departments))
                ->whereNull('solna_helper') // Only delete man records (no helper)
                ->delete();
        }

        $allowedDepartments = [23, 25, 26, 29];
        $records = [];
        $now = now();

        // Process each man
        for ($i = 0; $i < $maxCount; $i++) {
            // Get department from man
            $department = null;
            if (isset($dataArrays['solna_man'][$i])) {
                [, $department] = $this->extractCnicAndDepartment($dataArrays['solna_man'][$i]);
            }

            // Skip if no department or not allowed
            if (!$department || !in_array((int)$department, $allowedDepartments)) {
                continue;
            }

            // Create man record
            $record = [
                'v_no' => $v_no,
                'department_id' => $department,
                'solna_man' => $dataArrays['solna_man'][$i] ?? null,
                'solna_date_machine' => $dataArrays['solna_date_machine'][$i] ?? null,
                'solna_machine' => $dataArrays['solna_machine'][$i] ?? null,
                'solna_man_impression' => $dataArrays['solna_man_impression'][$i] ?? null,
                'solna_man_waste' => $dataArrays['solna_man_waste'][$i] ?? null,
                'solna_date_helper' => null, // Men don't have helper date
                'solna_machine_helper' => null, // Men don't have helper machine
                'solna_helper' => null, // This is a man record
                'solna_helper_impression' => null,
                'solna_helper_waste' => null,
                'manual_impression' => $request->input('manual_impression'),
                'helper_impression' => $request->input('helper_impression'),
                'solna_total_job_sheet_impression' => $request->input('solna_total_job_sheet_impression'),
                'solna_supervisor_impression' => $request->input('solna_supervisor_impression'),
                'ink_item' => $dataArrays['ink_item'][$i] ?? null,
                'ink_qty' => $dataArrays['ink_qty'][$i] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $records[] = $record;
        }

        if (!empty($records)) {
            Solna::insert($records);
        }
    }

    /**
     * Process only Helpers for Solna
     */
    private function processSolnaHelpers(Request $request, string $v_no): void
    {
        $dataArrays = [
            'solna_date_helper' => $this->normalizeToArray($request->input('solna_date_helper', [])),
            'solna_machine_helper' => $this->normalizeToArray($request->input('solna_machine_helper', [])),
            'solna_helper' => $this->normalizeToArray($request->input('solna_helper', [])),
            'solna_helper_impression' => $this->normalizeToArray($request->input('solna_helper_impression', [])),
            'solna_helper_waste' => $this->normalizeToArray($request->input('solna_helper_waste', [])),
        ];

        // Find maximum count for helpers
        $maxCount = 0;
        foreach ($dataArrays as $array) {
            $maxCount = max($maxCount, count($array));
        }

        // Get all possible departments from men (for helper department assignment)
        $manDepartments = [];
        $solnaMen = $this->normalizeToArray($request->input('solna_man', []));
        foreach ($solnaMen as $man) {
            [, $department] = $this->extractCnicAndDepartment($man);
            if ($department) {
                $manDepartments[] = $department;
            }
        }
        $defaultDepartment = !empty($manDepartments) ? $manDepartments[0] : 23;

        $allowedDepartments = [23, 25, 26, 29];
        $records = [];
        $now = now();

        // Process each helper
        for ($i = 0; $i < $maxCount; $i++) {
            // Skip if helper has no data
            if (empty($dataArrays['solna_helper_impression'][$i]) && empty($dataArrays['solna_helper'][$i])) {
                continue;
            }

            // Get department from helper or use default
            $department = null;
            if (isset($dataArrays['solna_helper'][$i])) {
                [, $department] = $this->extractCnicAndDepartment($dataArrays['solna_helper'][$i]);
            }

            // If no department from helper, use default
            if (!$department || !in_array((int)$department, $allowedDepartments)) {
                $department = $defaultDepartment;
            }

            // Get first man's data for reference (optional)
            $solnaMenArray = $this->normalizeToArray($request->input('solna_man', []));
            $firstManData = !empty($solnaMenArray) ? $solnaMenArray[0] : null;
            [$manCnic,] = $this->extractCnicAndDepartment($firstManData);

            $solnaMachineArray = $this->normalizeToArray($request->input('solna_machine', []));
            $firstMachine = !empty($solnaMachineArray) ? $solnaMachineArray[0] : null;

            $solnaDateMachineArray = $this->normalizeToArray($request->input('solna_date_machine', []));
            $firstDateMachine = !empty($solnaDateMachineArray) ? $solnaDateMachineArray[0] : null;

            $solnaManImpArray = $this->normalizeToArray($request->input('solna_man_impression', []));
            $firstManImp = !empty($solnaManImpArray) ? $solnaManImpArray[0] : null;

            $solnaManWasteArray = $this->normalizeToArray($request->input('solna_man_waste', []));
            $firstManWaste = !empty($solnaManWasteArray) ? $solnaManWasteArray[0] : null;

            // Create helper record
            $record = [
                'v_no' => $v_no,
                'department_id' => $department,
                'solna_man' => $manCnic, // Reference to first man (optional)
                'solna_date_machine' => $firstDateMachine, // Same as man's date
                'solna_machine' => $firstMachine, // Same as man's machine
                'solna_man_impression' => $firstManImp, // Man's impression for reference
                'solna_man_waste' => $firstManWaste, // Man's waste for reference
                'solna_date_helper' => $dataArrays['solna_date_helper'][$i] ?? null,
                'solna_machine_helper' => $dataArrays['solna_machine_helper'][$i] ?? null,
                'solna_helper' => $dataArrays['solna_helper'][$i] ?? null,
                'solna_helper_impression' => $dataArrays['solna_helper_impression'][$i] ?? null,
                'solna_helper_waste' => $dataArrays['solna_helper_waste'][$i] ?? null,
                'manual_impression' => $request->input('manual_impression'),
                'helper_impression' => $request->input('helper_impression'),
                'solna_total_job_sheet_impression' => $request->input('solna_total_job_sheet_impression'),
                'solna_supervisor_impression' => $request->input('solna_supervisor_impression'),
                'ink_item' => null, // Helpers don't have ink
                'ink_qty' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $records[] = $record;
        }

        if (!empty($records)) {
            Solna::insert($records);
        }
    }

    /**
     * Process Dye data for departments 28, 31
     */
    private function processDyeData(Request $request, string $v_no): void
    {
        $dyeMan = $request->input('dye_man', []);
        $dyeMachine = $request->input('dye_machine', []);
        $dyeDateMachine = $request->input('dye_date_machine', []);
        $dyeManImp = $request->input('dye_man_impression', []);
        $dyeManWaste = $request->input('dye_man_waste', []);
        $dyeDateHelper = $request->input('dye_date_helper', []);
        $dyeMachineHelper = $request->input('dye_machine_helper', []);
        $dyeHelper = $request->input('dye_helper', []);
        $dyeHelperImp = $request->input('dye_helper_impression', []);
        $dyeHelperWaste = $request->input('dye_helper_waste', []);

        // Convert all to arrays
        $dyeMan = $this->normalizeToArray($dyeMan);
        $dyeMachine = $this->normalizeToArray($dyeMachine);
        $dyeDateMachine = $this->normalizeToArray($dyeDateMachine);
        $dyeManImp = $this->normalizeToArray($dyeManImp);
        $dyeManWaste = $this->normalizeToArray($dyeManWaste);
        $dyeDateHelper = $this->normalizeToArray($dyeDateHelper);
        $dyeMachineHelper = $this->normalizeToArray($dyeMachineHelper);
        $dyeHelper = $this->normalizeToArray($dyeHelper);
        $dyeHelperImp = $this->normalizeToArray($dyeHelperImp);
        $dyeHelperWaste = $this->normalizeToArray($dyeHelperWaste);

        $max = $this->getMaxArrayCount([
            $dyeMan,
            $dyeMachine,
            $dyeDateMachine,
            $dyeManImp,
            $dyeManWaste,
            $dyeDateHelper,
            $dyeMachineHelper,
            $dyeHelper,
            $dyeHelperImp,
            $dyeHelperWaste
        ]);

        $departments = $this->extractDepartments($dyeMan, $max);

        if (!empty($departments)) {
            DyeJob::where('v_no', $v_no)
                ->whereIn('department_id', $departments)
                ->delete();
        }

        $allowedDepartments = [28, 31];
        $records = [];
        $now = now();

        for ($i = 0; $i < $max; $i++) {
            [$cnic, $department] = $this->extractCnicAndDepartment($dyeMan[$i] ?? null);

            if (!$department || !in_array((int)$department, $allowedDepartments)) {
                continue;
            }

            $records[] = [
                'v_no' => $v_no,
                'department_id' => $department,
                'dye_man' => $cnic,
                'dye_machine' => $dyeMachine[$i] ?? null,
                'dye_date_machine' => $dyeDateMachine[$i] ?? null,
                'dye_man_impression' => $dyeManImp[$i] ?? null,
                'dye_man_waste' => $dyeManWaste[$i] ?? null,
                'dye_date_helper' => $dyeDateHelper[$i] ?? null,
                'dye_machine_helper' => $dyeMachineHelper[$i] ?? null,
                'dye_helper' => $dyeHelper[$i] ?? null,
                'dye_helper_impression' => $dyeHelperImp[$i] ?? null,
                'dye_helper_waste' => $dyeHelperWaste[$i] ?? null,
                'total_manual_impression' => $request->input('dye_total_manual_impression'),
                'total_helper_impression' => $request->input('dye_total_helper_impression'),


                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($records)) {
            DyeJob::insert($records);
        }
    }

    /**
     * Process Lamination data for departments 22, 33
     */
    private function processLaminationData(Request $request, string $v_no): void
    {
        $laminationMachine = $request->input('lamination_machine', []);
        $laminationDateMachine = $request->input('lamination_date_machine', []);
        $laminationMan = $request->input('lamination_man', []);
        $laminationManImp = $request->input('lamination_man_impression', []);
        $laminationManWaste = $request->input('lamination_man_waste', []);
        $glueItem = $request->input('lamination_glue', []);
        $glueQty = $request->input('glue_qty', []);
        $laminationItem = $request->input('lamination_item', []);
        $laminationQty = $request->input('lamination_qty', []);
        $size = $request->input('size', []);

        // Convert all to arrays
        $laminationMachine = $this->normalizeToArray($laminationMachine);
        $laminationDateMachine = $this->normalizeToArray($laminationDateMachine);
        $laminationMan = $this->normalizeToArray($laminationMan);
        $laminationManImp = $this->normalizeToArray($laminationManImp);
        $laminationManWaste = $this->normalizeToArray($laminationManWaste);
        $glueItem = $this->normalizeToArray($glueItem);
        $glueQty = $this->normalizeToArray($glueQty);
        $laminationItem = $this->normalizeToArray($laminationItem);
        $laminationQty = $this->normalizeToArray($laminationQty);
        $size = $this->normalizeToArray($size);

        $max = $this->getMaxArrayCount([
            $laminationMan,
            $laminationManImp,
            $laminationManWaste,
            $laminationMachine,
            $laminationDateMachine,
            $glueItem,
            $glueQty,
            $laminationItem,
            $laminationQty,
            $size
        ]);

        // Get existing department ID
        $laminationRecord = Lamination::where('v_no', $v_no)
            ->whereIn('department_id', [22, 33])
            ->first();

        $departmentId = $laminationRecord->department_id ?? 22;

        // Delete existing records
        Lamination::where('v_no', $v_no)
            ->whereIn('department_id', [22, 33])
            ->delete();

        $records = [];
        $now = now();

        for ($i = 0; $i < $max; $i++) {
            [$cnic, $department] = $this->extractCnicAndDepartment($laminationMan[$i] ?? null);

            $record = [
                'v_no' => $v_no,
                'department_id' => $departmentId,
                'lamination_man' => $cnic,
                'lamination_date_machine' => $laminationDateMachine[$i] ?? null,
                'lamination_machine' => $laminationMachine[$i] ?? null,
                'lamination_man_impression' => $laminationManImp[$i] ?? null,
                'lamination_man_waste' => $laminationManWaste[$i] ?? null,
                'lamination_manual_impression' => $request->input('lamination_manual_impression'),



                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (isset($glueItem[$i])) {
                $record['glue_item'] = $glueItem[$i];
                $record['glue_qty'] = $glueQty[$i] ?? null;
            }

            if (isset($laminationItem[$i])) {
                $record['lamination_item'] = $laminationItem[$i];
                $record['lamination_qty'] = $laminationQty[$i] ?? null;
                $record['lamination_size'] = $size[$i] ?? null;
            }

            // Only add record if we have some data
            if (
                $cnic || $laminationMachine[$i] || $laminationDateMachine[$i] ||
                $glueItem[$i] || $laminationItem[$i]
            ) {
                $records[] = $record;
            }
        }

        if (!empty($records)) {
            Lamination::insert($records);
        }
    }

    /**
     * Process Corrugation data for department 13
     */
    private function processCorrugationData(Request $request, string $v_no): void
    {
        $corrugationDateMachine = $request->input('corrugation_date_machine', []);
        $corrugationBox = $request->input('corrugation_box', []);
        $corrugationPacking = $request->input('corrugation_packing', []);
        $corrugationTotalBox = $request->input('corrugation_total_boxes', []);

        // Convert all to arrays
        $corrugationDateMachine = $this->normalizeToArray($corrugationDateMachine);
        $corrugationBox = $this->normalizeToArray($corrugationBox);
        $corrugationPacking = $this->normalizeToArray($corrugationPacking);
        $corrugationTotalBox = $this->normalizeToArray($corrugationTotalBox);

        $max = $this->getMaxArrayCount([
            $corrugationDateMachine,
            $corrugationBox,
            $corrugationPacking,
            $corrugationTotalBox
        ]);

        Corrugation::where('v_no', $v_no)
            ->where('department_id', 13)
            ->delete();

        $records = [];
        $now = now();

        for ($i = 0; $i < $max; $i++) {
            $record = [
                'v_no' => $v_no,
                'department_id' => 13,
                'corrugation_date_machine' => $corrugationDateMachine[$i] ?? null,
                'corrugation_box' => $corrugationBox[$i] ?? null,
                'corrugation_packing' => $corrugationPacking[$i] ?? null,
                'corrugation_total_boxes' => $corrugationTotalBox[$i] ?? null,
                'corrugation_item_type' => $request->input('corrugation_item_type'),
                'po_order_qty' => $request->input('po_order_qty'),
                'finish_product_qty' => $request->input('finish_product_qty'),
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Only add record if we have some data
            if ($corrugationDateMachine[$i] || $corrugationBox[$i] || $corrugationPacking[$i] || $corrugationTotalBox[$i]) {
                $records[] = $record;
            }
        }

        if (!empty($records)) {
            Corrugation::insert($records);
        }
    }

    /**
     * Process Breaking data for department 20
     */
    private function processBreakingData(Request $request, string $v_no): void
    {
        $breakingDateMachine = $request->input('breaking_date_machine', []);
        $breakingContractor = $request->input('breaking_contractor', []);
        $breakingImpression = $request->input('breaking_impression', []);
        $breakingWaste = $request->input('breaking_waste', []);

        // Convert all to arrays
        $breakingDateMachine = $this->normalizeToArray($breakingDateMachine);
        $breakingContractor = $this->normalizeToArray($breakingContractor);
        $breakingImpression = $this->normalizeToArray($breakingImpression);
        $breakingWaste = $this->normalizeToArray($breakingWaste);

        $max = $this->getMaxArrayCount([
            $breakingDateMachine,
            $breakingContractor,
            $breakingImpression,
            $breakingWaste
        ]);

        Breaking::where('v_no', $v_no)
            ->where('department_id', 20)
            ->delete();

        $records = [];
        $now = now();

        for ($i = 0; $i < $max; $i++) {
            // Extract CNIC if format is "CNIC|Department"
            $contractor = $breakingContractor[$i] ?? null;
            if ($contractor && strpos($contractor, '|') !== false) {
                $parts = explode('|', $contractor);
                $contractor = trim($parts[0] ?? $contractor);
            }

            $records[] = [
                'v_no' => $v_no,
                'department_id' => 20,
                'breaking_date_machine' => $breakingDateMachine[$i] ?? null,
                'breaking_contractor' => $contractor,
                'breaking_impression' => $breakingImpression[$i] ?? null,
                'breaking_waste' => $breakingWaste[$i] ?? null,
                'breaking_total_impression' => $request->input('breaking_total_impression'),
                'breaking_total_waste' => $request->input('breaking_total_waste'),


                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($records)) {
            Breaking::insert($records);
        }
    }

    /**
     * Normalize input to array
     */
    private function normalizeToArray($input): array
    {
        if (is_null($input)) {
            return [];
        }
        return is_array($input) ? $input : [$input];
    }

    /**
     * Helper function to get maximum count from arrays
     */
    private function getMaxArrayCount(array $arrays): int
    {
        if (empty($arrays)) {
            return 0;
        }

        $counts = array_map('count', $arrays);
        return max($counts);
    }

    /**
     * Extract departments from man arrays
     */
    private function extractDepartments(array $manArray, int $max): array
    {
        $departments = [];

        for ($i = 0; $i < $max; $i++) {
            if (!empty($manArray[$i]) && strpos($manArray[$i], '|') !== false) {
                $parts = explode('|', $manArray[$i]);
                if (isset($parts[1]) && is_numeric($parts[1])) {
                    $departments[] = (int)$parts[1];
                }
            }
        }

        return array_unique($departments);
    }

    /**
     * Extract CNIC and department from man string
     */
    private function extractCnicAndDepartment(?string $manString): array
    {
        if (empty($manString)) {
            return [null, null];
        }

        if (strpos($manString, '|') === false) {
            return [$manString, null];
        }

        $parts = explode('|', $manString);
        return [
            trim($parts[0] ?? null),
            isset($parts[1]) && is_numeric($parts[1]) ? (int)$parts[1] : null
        ];
    }

    public function editAsJobSheet($v_no)
    {

        $jobDetails = JobDetail::where('v_no', $v_no)->get();
        $currentJobDetail = $jobDetails->first();
        // Fetch the related product (if any)
        $product = null;
        if ($currentJobDetail && $currentJobDetail->product_id) {
            $product = ProductMaster::find($currentJobDetail->product_id);
        }
        $solnas = Solna::where('v_no', $v_no)->get();
        $laminations = Lamination::where('v_no', $v_no)->get();

        $dyes = DyeJob::where('v_no', $v_no)->get();
        $breakings = Breaking::where('v_no', $v_no)
            ->get();

        $corrugations = Corrugation::where('v_no', $v_no)->get();

        $departments = DB::table('employee_type_details')->pluck('department_name', 'department_id');
        $designations = DB::table('employee_type_details')->pluck('designation_name', 'designation_id');
        $employees = DB::table('employee_type_details')->pluck('employee_name', 'cnic_no');

        // If no records found, redirect back with an error message
        if ($jobDetails->isEmpty()) {
            return back()->with('error', "No job details found for V No {$v_no}");
        }

        $itemMasters = ItemMaster::all();
        $accountMasters = AccountMaster::all();
        $processSections = ProcessSection::all();
        $loggedInUser = Auth::user();
        $productMasters2 = DB::table('product_master')
            ->join('account_masters', 'product_master.aid', '=', 'account_masters.id')
            ->select('product_master.aid', 'account_masters.title')
            ->get()
            ->unique('title');

        $boxboardData = DB::table('boxboard_view')
            ->select('item_id', 'item_code', 'width', 'length', 'remain_qty')
            ->get();

        $inkData = DB::table('ink_view')
            ->select('item', 'remain_qty', 'item_code')
            ->get();

        $glueData = DB::table('glue_view')
            ->select('item', 'remain_qty', 'item_code')
            ->get();

        $shipperData = DB::table('shipper_view')
            ->select('item', 'remain_qty', 'item_code')
            ->get();

        $laminationData = DB::table('lamination_view')
            ->select('total_qty', 'remain_qty', 'item_id', 'size', 'item_name')
            ->get();

        $boxMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name')
            ->get();

        $solnaMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();

        $dyeMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();

        $laminationMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();
        // dd($laminationMachine);

        $corrugationMachine = DB::table('machine_view')
            ->select('dept_id', 'department_name', 'process_name', 'process_id')
            ->get();


        $employeeTypes = DB::table('employee_type_details')->get();
        $employeeProcess = DB::table('employee_processes')->get();

        $employeeTypeBox = DB::table('employee_type_details')
            ->where('department_id', 21)
            ->select('cnic_no', 'employee_name', 'department_name')
            ->orderBy('employee_name')
            ->get();


        $employeeTypeSolna = DB::table('employee_type_details')
            ->whereIn('department_id', [23, 25, 26, 29])
            ->where('designation_id', 7)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();

        $employeeTypeSolnaHelper = DB::table('employee_type_details')
            ->whereIn('department_id', [23, 25, 26, 29])
            ->where('designation_id', 8)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();

        $employeeTypedye = DB::table('employee_type_details')
            ->whereIn('department_id', [28, 31])
            ->where('designation_id', 7)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();


        $employeeTypedyeHelper = DB::table('employee_type_details')
            ->whereIn('department_id', [28, 31])
            ->where('designation_id', 8)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();


        $employeeTypeLamination = DB::table('employee_type_details')
            ->whereIn('department_id', [22, 33])
            ->where('designation_id', 7)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();
        // dd($employeeTypeLamination);
        $employeeTypebreaking = DB::table('employee_type_details')
            ->whereIn('department_id', [20])
            ->where('designation_id', 10)
            ->select('cnic_no', 'department_id', 'employee_name', 'department_name', 'designation_name')
            ->orderBy('employee_name')
            ->get();

        $SolnaMans = SolnasManDetail::where('v_no', $v_no)->get();
        if ($SolnaMans->isEmpty()) {
            $SolnaMans = collect(); // empty collection
        }

        $SolnaHelpers = SolnasHelperDetail::where('v_no', $v_no)->get();
        if ($SolnaHelpers->isEmpty()) {
            $SolnaHelpers = collect(); // empty collection
        }

        $SolnaMaster = SolnasMaster::where('v_no', $v_no)->first();
        if (!$SolnaMaster) {
            $SolnaMaster = null; // or (object)[] if you want an empty object
        }

        $inkItemsQty = InkPurchase::with('items')->select('item_code')->distinct()->get();
        $dyeItemsQty = DyePurchase::with('items')->select('item_code')->distinct()->get();
        // dd($dyeItemsQty);
        $plateItemsQty = PurchasePlate::with('items')->select('item_code')->distinct()->get();
        $laminationItemsQty = LaminationPurchase::with('item')
            ->select('item_id', 'size')
            ->distinct()
            ->get();

        $glueItemsQty = GluePurchase::with('items')->select('item_code')->distinct()->get();
        // dd($glueItemsQty);

        if ($SolnaMaster) {
            $solnaInk = InkJobSheet::where('v_no', $v_no)->where('department_id', $SolnaMaster->id)->get();
            $solnaPlate = PlateJobSheet::where('v_no', $v_no)->where('department_id', $SolnaMaster->id)->get();
        } else {
            $solnaInk = collect();
            $solnaPlate = collect();
        }



        $laminationRecord = LaminationMaster::where('v_no', $v_no)->first();
        $laminationdetail = LaminationDetail::where('v_no', $v_no)->get();

        $dyeRecord = DyeMaster::where('v_no', $v_no)->first();
        $dyedetail = DyeDetail::where('v_no', $v_no)->get();

        if ($laminationRecord) {
            $laminationGlue = GlueJobSheet::where('v_no', $v_no)->where('department_id', $laminationRecord->department_id)->get();
            // dd($laminationGlue);
            $laminationItems = LaminationJobSheet::where('v_no', $v_no)->where('department_id', $laminationRecord->department_id)->get();
            // Debug
        } else {
            $laminationGlue = collect();
            $laminationItems = collect();
        }
        if ($dyeRecord) {
            $dyeItems = DyeJobSheet::where('v_no', $v_no)->where('department_id', $dyeRecord->department_id)->get();
        } else {
            $dyeItems = collect();
        }

        return view('jobsheet.pasting', compact(
            'jobDetails',
            'laminationItemsQty',
            'glueItemsQty',
            'laminationRecord',
            'laminationdetail',
            'laminationItems',
            'laminationGlue',
            'solnaInk',
            'solnaPlate',
            'dyeItems',
            'plateItemsQty',
            'SolnaMans',
            'SolnaHelpers',
            'SolnaMaster',
            'dyeItemsQty',
            'currentJobDetail',
            'product',
            'dyeMachine',
            'shipperData',
            'employeeTypebreaking',
            'laminationData',
            'corrugations',
            'breakings',
            'laminationMachine',
            'inkItemsQty',
            'corrugationMachine',
            'solnaMachine',
            'glueData',
            'laminations',
            'employeeTypeLamination',
            'employeeTypedye',
            'employeeTypedyeHelper',
            'dyes',
            'inkData',
            'solnas',
            'employeeTypeSolnaHelper',
            'itemMasters',
            'employeeTypeSolna',
            'employeeTypeBox',
            'boxMachine',
            'accountMasters',
            'processSections',
            'loggedInUser',
            'productMasters2',
            'boxboardData',
            'employeeTypes',
            'employeeProcess',
            'departments',
            'designations',
            'employees'
        ));
    }
}
