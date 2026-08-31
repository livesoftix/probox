<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\AccountMaster;
use App\Models\Employees;
use App\Models\EmployeeType;
use App\Models\ErpParam;
use App\Models\JobDetail;
use App\Models\TRNDTL;
use App\Models\ProductMaster;
use App\Models\WageBreakingDc;
use App\Models\CorrugationMaster;
use App\Models\DeliveryMaster;
use App\Models\ConfectioneryMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WageBreakingDcController extends Controller
{
public function index()
{
    $loggedInUser = auth()->user();

    $startDate = Carbon::create(2026, 7, 25)->startOfDay();
    $endDate   = Carbon::today()->endOfDay();

    /*
    |--------------------------------------------------------------------------
    | Pharma Products
    |--------------------------------------------------------------------------
    */

    $pharmaProducts = DeliveryMaster::with([
        'deliveryDetails.products'
    ])
    ->where('v_type', 'PDC')
    ->whereBetween('date', [$startDate, $endDate])
    ->get()
    ->filter(function ($dc) {

        if (!$dc->deliveryDetails) {
            return false;
        }

        $detail = $dc->deliveryDetails;

        $prodId  = $detail->product_name;
        $batchNo = $detail->batch_no;

        $product = ProductMaster::find($prodId);

        if (!$product || $product->breaking != 1) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Same DC + Same Product + Same Batch already used?
        |--------------------------------------------------------------------------
        */

        $alreadyUsed = WageBreakingDc::where('dc_type', 'pharma')
            ->where('v_no', $dc->v_no)
            ->where('prod_id', $prodId)
            ->where('batch_no', $batchNo)
            ->exists();

        return !$alreadyUsed;
    })
    ->map(function ($master) {

        $detail = $master->deliveryDetails;

        return [
            'id'       => $detail->product_name,
            'name'     => optional($detail->products)->prod_name,
            'batch_no' => $detail->batch_no,
            'type'     => 'pharma',
        ];
    });

    /*
    |--------------------------------------------------------------------------
    | Confectionery Products
    |--------------------------------------------------------------------------
    */

    $confectioneryProducts = ConfectioneryMaster::with([
        'confectioneryDetails.products'
    ])
    ->where('v_type', 'CDC')
    ->whereBetween('date', [$startDate, $endDate])
    ->get()
    ->filter(function ($dc) {

        if (!$dc->confectioneryDetails) {
            return false;
        }

        $detail = $dc->confectioneryDetails;

        $prodId  = $detail->product_name;
        $batchNo = $detail->po_no;

        $product = ProductMaster::find($prodId);

        if (!$product || $product->breaking != 1) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Same DC + Same Product + Same PO/Batch already used?
        |--------------------------------------------------------------------------
        */

        $alreadyUsed = WageBreakingDc::where('dc_type', 'confectionery')
            ->where('v_no', $dc->v_no)
            ->where('prod_id', $prodId)
            ->where('batch_no', $batchNo)
            ->exists();

        return !$alreadyUsed;
    })
    ->map(function ($master) {

        $detail = $master->confectioneryDetails;

        return [
            'id'       => $detail->product_name,
            'name'     => optional($detail->products)->prod_name,
            'batch_no' => $detail->po_no,
            'type'     => 'confectionery',
        ];
    });

    /*
    |--------------------------------------------------------------------------
    | Combine Products
    |--------------------------------------------------------------------------
    */

    $products = $pharmaProducts
        ->concat($confectioneryProducts)
        ->unique(function ($item) {
            return $item['id']
                . '-' . $item['batch_no']
                . '-' . $item['type'];
        })
        ->sortBy('name')
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Employees
    |--------------------------------------------------------------------------
    */

    $employees = Employees::whereHas('employeeType', function ($query) {
        $query->where('department_id', 12);
    })->get();

    return view(
        'wages.breaking.list',
        compact(
            'loggedInUser',
            'products',
            'employees'
        )
    );
}
public function getVoucherDetails($type, $v_no)
{
    $rows = [];

    if ($type === 'pharma') {

        // First get the selected DC to identify the product
        $selectedMaster = DeliveryMaster::with([
            'deliveryDetails.products'
        ])
        ->where('v_no', $v_no)
        ->where('v_type', 'PDC')
        ->first();

        if (!$selectedMaster || !$selectedMaster->deliveryDetails) {
            return response()->json([]);
        }

        $selectedDetails = $selectedMaster->deliveryDetails;

        $prodId = $selectedDetails->product_name;
        $batchNo = $selectedDetails->batch_no;

        /*
        |--------------------------------------------------------------------------
        | Get ALL Pharma DCs having the same product + batch
        |--------------------------------------------------------------------------
        */
        $masters = DeliveryMaster::with([
            'accounts',
            'deliveryDetails.products'
        ])
        ->where('v_type', 'PDC')
        ->whereBetween('date', [
            Carbon::create(2026, 7, 25)->startOfDay(),
            Carbon::today()->endOfDay()
        ])
        ->whereHas('deliveryDetails', function ($q) use ($prodId, $batchNo) {
            $q->where('product_name', $prodId)
              ->where('batch_no', $batchNo);
        })
        ->get();

        foreach ($masters as $master) {

            $details = $master->deliveryDetails;

            if (!$details) {
                continue;
            }

            $product = ProductMaster::find($details->product_name);

            $clabour = $product?->breaking_rate ?? 0;

            $rows[] = [
                'v_no' => $master->v_no,
                'date' => $master->date,
                'account_id' => $master->account_id,
                'account_name' => $master->accounts?->title ?? 'N/A',
                'product_name' => $product?->prod_name ?? 'N/A',
                'batch_no' => $details?->batch_no ?? 'N/A',
                'qty' => ($details->pack_qty ?? 0) * ($details->box ?? 0),
                'type' => 'pharma',
                'prod_id' => $details->product_name,
                'clabour' => $clabour,
            ];
        }

    } elseif ($type === 'confectionery') {

        // First get the selected DC to identify the product
        $selectedMaster = ConfectioneryMaster::with([
            'confectioneryDetails.products'
        ])
        ->where('v_no', $v_no)
        ->where('v_type', 'CDC')
        ->first();

        if (!$selectedMaster || !$selectedMaster->confectioneryDetails) {
            return response()->json([]);
        }

        $selectedDetails = $selectedMaster->confectioneryDetails;

        $prodId = $selectedDetails->product_name;
        $batchNo = $selectedDetails->po_no;

        /*
        |--------------------------------------------------------------------------
        | Get ALL Confectionery DCs having the same product + PO
        |--------------------------------------------------------------------------
        */
        $masters = ConfectioneryMaster::with([
            'accounts',
            'confectioneryDetails.products'
        ])
        ->where('v_type', 'CDC')
        ->whereBetween('date', [
            Carbon::create(2026, 7, 25)->startOfDay(),
            Carbon::today()->endOfDay()
        ])
        ->whereHas('confectioneryDetails', function ($q) use ($prodId, $batchNo) {
            $q->where('product_name', $prodId)
              ->where('po_no', $batchNo);
        })
        ->get();

        foreach ($masters as $master) {

            $details = $master->confectioneryDetails;

            if (!$details) {
                continue;
            }

            $product = ProductMaster::find($details->product_name);

            $clabour = $product?->breaking_rate ?? 0;

            $rows[] = [
                'v_no' => $master->v_no,
                'date' => $master->date,
                'account_id' => $master->account_id,
                'account_name' => $master->accounts?->title ?? 'N/A',
                'product_name' => $product?->prod_name ?? 'N/A',
                'batch_no' => $details?->po_no ?? 'N/A',
                'qty' => ($details->pack_qty ?? 0) * ($details->box ?? 0),
                'type' => 'confectionery',
                'prod_id' => $details->product_name,
                'clabour' => $clabour,
            ];
        }
    }

    return response()->json($rows);
}

public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'prepared_by' => 'required|string|max:255',

        'v_no' => 'required|array',
        'v_no.*' => 'required|string',

        'dc_date' => 'required|array',
        'account_id' => 'required|array',
        'product_name' => 'required|array',
        'prod_id' => 'required|array',
        'qty' => 'required|array',
        'clabour' => 'required|array',
        'dc_type' => 'required|array',
        
    ]);

    DB::transaction(function () use ($request) {

        $contractor = EmployeeType::where('department_id', 12)
            ->where('designation_id', 10)
            ->firstOrFail();
        // dd($contractor);

        $contractorAccountId = $contractor->cnic_no;
        $acc=Employees::where('id',$contractorAccountId)->firstOrFail();
        $acc_id=$acc->cad;
        // dd($acc_id->cad);
        $lastEntry = WageBreakingDc::orderByDesc('id')->first();
        $newInvoiceNumber = $lastEntry
            ? ((int) $lastEntry->b_no + 1)
            : 1;


        $entries = [];
        $totalAmount = 0;
        $totalDeduction = 0;
        $totalOtherExp = 0;

        foreach ($request->v_no as $index => $vNo) {

            $qty = (float) $request->qty[$index];
            $clabour = (float) $request->clabour[$index];

            $amount = $qty * $clabour;

            $totalAmount += $amount;

            $entries[] = [
                'v_no' => $vNo,
                'dc_date' => $request->dc_date[$index],
                'account_id' => $request->account_id[$index],
                'prod_id' => $request->prod_id[$index],
                'product_name' => $request->product_name[$index],
                'batch_no' => $request->batch_no[$index],
                'qty' => $qty,
                'clabour' => $clabour,
                'breaking_wage' => $amount,
                'dc_type' => $request->dc_type[$index],
            ];
        }

        $firstEntry = null;

        foreach ($entries as $entry) {

            $wage = WageBreakingDc::create([
                'b_no' => $newInvoiceNumber,
                'v_no' => $entry['v_no'],
                'dc_date' => $entry['dc_date'],
                'account_id' => $entry['account_id'],
                'prod_id' => $entry['prod_id'],
                'product_name' => $entry['product_name'],
                'batch_no' => $entry['batch_no'],
                'qty' => $entry['qty'],
                'clabour' => $entry['clabour'],
                'breaking_wage' => $entry['breaking_wage'],
                'total_amount' => $totalAmount,
                'dc_type' => $entry['dc_type'],
                'date' => $request->date,
                'prepared_by' => $request->prepared_by,
                'v_type' => 'Breaking DC',
            ]);

            if (!$firstEntry) {
                $firstEntry = $wage;
            }
        }
        // Employee deductions
if ($request->has('employee_id')) {

    foreach ($request->employee_id as $index => $employeeId) {

        if (empty($employeeId)) {
            continue;
        }

        $employee = Employees::find($employeeId);

        if (!$employee) {
            continue;
        }

        $deduction = (float)($request->deduction[$index] ?? 0);
        $otherExp = (float)($request->otherExp[$index] ?? 0);
        $previousLoan = (float)($request->previous_loan[$index] ?? 0);
        $remainingLoan = (float)($request->remaining[$index] ?? 0);
        $description   = $request->description[$index] ?? null;

        $totalDeduction += $deduction;
        $totalOtherExp += $otherExp;

        // Save against wage table
        WageBreakingDc::create([
            'b_no'            => $newInvoiceNumber,
            'employee_id'     => $employeeId,
            'previous_loan'   => $previousLoan,
            'deduction'       => $deduction,
            'remaining_loan'  => $remainingLoan,
            'total_amount'    => $totalAmount,
            'date'            => $request->date,
            'prepared_by'     => $request->prepared_by,
            'v_type'          => 'Breaking DC',
            'other_exp'       => $otherExp,
            'description'     =>$description
        ]);

        // Employee Loan Credit Entry
        TRNDTL::create([
            'v_no'        => $newInvoiceNumber,
            'date'        => $request->date,
            'description' => 'Wage breaking Dc Deduction ',
            'account_id'  => $employee->advance_cad,
            'cash_id'     => null,
            'preparedby'  => auth()->user()->name,
            'debit'       => 0,
            'credit'      => $deduction,
            'status'      => 'unofficial',
            'v_type'      => 'Wage Breaking DC',
        ]);
         // Employee Salary Credit Entry
        TRNDTL::create([
            'v_no'        => $newInvoiceNumber,
            'date'        => $request->date,
            'description' => $description,
            'account_id'  => $employee->cad,
            'cash_id'     => null,
            'preparedby'  => auth()->user()->name,
            'debit'       => 0,
            'credit'      => $otherExp,
            'status'      => 'unofficial',
            'v_type'      => 'Wage Breaking DC',
        ]);
        $remaining=$totalAmount-$deduction + $otherExp;
                TRNDTL::create([
                    'v_no'=>$newInvoiceNumber,
                    'date'=>$request->date,
                    'description'=>'Wage Deduction DC after deduction',
                    'account_id'=>$employee->cad,
                    'credit'=>$remaining,
                    'debit'=>0,
                    'preparedby'=>auth()->user()->name,
                    'status'=>'unofficial',
                    'v_type'=>'Wage Breaking DC'
                ]);
    }
}
// $contractorAmount = $totalAmount - $totalDeduction;
//         TRNDTL::create([
//             'v_no' => $newInvoiceNumber,
//             'date' => $request->date,
//             'description' => 'Wage Breaking DC',
//             'account_id' => $acc_id,
//             'cash_id' => null,
//             'preparedby' => auth()->user()->name,
//             'credit' => $contractorAmount,
//             'debit' => 0,
//             'status' => 'unofficial',
//             'v_type' => 'Wage Breaking DC',
//             'r_id' => $firstEntry?->id,
//         ]);
    });

    return redirect()
        ->route('breaking_wage_dc.report')
        ->with('success', 'Wage Breaking DC stored successfully.');
}

public function edit($b_no)
{
    $loggedInUser = auth()->user();

    $voucher = WageBreakingDc::where('b_no', $b_no)->firstOrFail();

    // Product rows
    $entries = WageBreakingDc::where('b_no', $b_no)
        ->whereNotNull('v_no')
        ->get();

    // Employee rows
    $employeeRows = WageBreakingDc::where('b_no', $b_no)
        ->whereNotNull('employee_id')
        ->get();

    // Employees
    $employees = Employees::whereHas('employeeType', function ($query) {
        $query->where('department_id', 12);
    })->get();

    /*
    |--------------------------------------------------------------------------
    | Date Range
    |--------------------------------------------------------------------------
    */

    $startDate = Carbon::create(2026, 7, 25)->startOfDay();
    $endDate   = Carbon::today()->endOfDay();

    /*
    |--------------------------------------------------------------------------
    | Pharma Products
    |--------------------------------------------------------------------------
    |
    | A batch is considered used only when:
    | DC No + Product ID + Batch No + Type
    |
    */

    $pharmaProducts = collect();

    $pharmaDCs = DeliveryMaster::with([
        'deliveryDetails.products'
    ])
        ->where('v_type', 'PDC')
        ->whereBetween('date', [$startDate, $endDate])
        ->get();

    foreach ($pharmaDCs as $dc) {

        /*
        |--------------------------------------------------------------------------
        | Get ALL details of this DC
        |--------------------------------------------------------------------------
        */
        $details = $dc->deliveryDetails()->get();

        foreach ($details as $detail) {

            if (!$detail) {
                continue;
            }

            $prodId = $detail->product_name;

            $product = ProductMaster::find($prodId);

            if (!$product || $product->breaking != 1) {
                continue;
            }

            $batchNo = $detail->batch_no;

            /*
            |--------------------------------------------------------------------------
            | Check ONLY this specific batch
            |--------------------------------------------------------------------------
            */
            $alreadyUsed = WageBreakingDc::where('b_no', '!=', $b_no)
                ->where('dc_type', 'pharma')
                ->where('v_no', $dc->v_no)
                ->where('prod_id', $prodId)
                ->where('batch_no', $batchNo)
                ->exists();

            if ($alreadyUsed) {
                continue;
            }

            $pharmaProducts->push([
                'id'       => $prodId,
                'name'     => optional($detail->products)->prod_name,
                'batch_no' => $batchNo,
                'type'     => 'pharma',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Confectionery Products
    |--------------------------------------------------------------------------
    */

    $confectioneryProducts = collect();

    $confectioneryDCs = ConfectioneryMaster::with([
        'confectioneryDetails.products'
    ])
        ->where('v_type', 'CDC')
        ->whereBetween('date', [$startDate, $endDate])
        ->get();

    foreach ($confectioneryDCs as $dc) {

        /*
        |--------------------------------------------------------------------------
        | Get ALL details of this DC
        |--------------------------------------------------------------------------
        */
        $details = $dc->confectioneryDetails()->get();

        foreach ($details as $detail) {

            if (!$detail) {
                continue;
            }

            $prodId = $detail->product_name;

            $product = ProductMaster::find($prodId);

            if (!$product || $product->breaking != 1) {
                continue;
            }

            $batchNo = $detail->po_no;

            /*
            |--------------------------------------------------------------------------
            | Check ONLY this specific batch
            |--------------------------------------------------------------------------
            */
            $alreadyUsed = WageBreakingDc::where('b_no', '!=', $b_no)
                ->where('dc_type', 'confectionery')
                ->where('v_no', $dc->v_no)
                ->where('prod_id', $prodId)
                ->where('batch_no', $batchNo)
                ->exists();

            if ($alreadyUsed) {
                continue;
            }

            $confectioneryProducts->push([
                'id'       => $prodId,
                'name'     => optional($detail->products)->prod_name,
                'batch_no' => $batchNo,
                'type'     => 'confectionery',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Combine Products
    |--------------------------------------------------------------------------
    */

    $products = $pharmaProducts
        ->concat($confectioneryProducts)
        ->unique(function ($item) {
            return $item['id']
                . '-'
                . $item['batch_no']
                . '-'
                . $item['type'];
        })
        ->sortBy('name')
        ->values();

    return view(
        'wages.breaking.edit',
        compact(
            'voucher',
            'entries',
            'employeeRows',
            'employees',
            'loggedInUser',
            'products'
        )
    );
}
public function update(Request $request, $b_no)
{
    // dd($request->v_no);
    $request->validate([
        'date'=>'required|date',
        'prepared_by'=>'required'
    ]);

    DB::transaction(function () use ($request, $b_no) {

        TRNDTL::where('v_no',$b_no)
            ->where('v_type','Wage Breaking DC')
            ->delete();

        WageBreakingDc::where('b_no',$b_no)->delete();

        $contractor = EmployeeType::where('department_id',20)
            ->where('designation_id',10)
            ->firstOrFail();

        $contractorAccountId = $contractor->cnic_no;

        $acc = Employees::findOrFail($contractorAccountId);

        $acc_id = $acc->cad;

        $entries=[];

        $totalAmount=0;
        $totalDeduction=0;

        foreach($request->v_no as $i=>$vNo){

            $qty=(float)$request->qty[$i];

            $rate=(float)$request->clabour[$i];

            $amount=$qty*$rate;

            $totalAmount += $amount;

            $entries[]=[
                'v_no'=>$vNo,
                'dc_date'=>$request->dc_date[$i],
                'account_id'=>$request->account_id[$i],
                'prod_id'=>$request->prod_id[$i],
                'product_name'=>$request->product_name[$i],
                'batch_no'=>$request->batch_no[$i],
                'qty'=>$qty,
                'clabour'=>$rate,
                'breaking_wage'=>$amount,
                'dc_type'=>$request->dc_type[$i]
            ];

        }

        $first=null;

        foreach($entries as $entry){

            $row=WageBreakingDc::create([
                'b_no'=>$b_no,
                'v_no'=>$entry['v_no'],
                'dc_date'=>$entry['dc_date'],
                'account_id'=>$entry['account_id'],
                'prod_id'=>$entry['prod_id'],
                'product_name'=>$entry['product_name'],
                'batch_no'=>$entry['batch_no'],
                'qty'=>$entry['qty'],
                'clabour'=>$entry['clabour'],
                'breaking_wage'=>$entry['breaking_wage'],
                'total_amount'=>$totalAmount,
                'dc_type'=>$entry['dc_type'],
                'date'=>$request->date,
                'prepared_by'=>$request->prepared_by,
                'v_type'=>'Breaking DC'
            ]);

            if(!$first){
                $first=$row;
            }
        }

        if($request->has('employee_id')){

            foreach($request->employee_id as $i=>$employeeId){

                if(empty($employeeId)){
                    continue;
                }

                $employee=Employees::find($employeeId);

                $deduction=(float)$request->deduction[$i];
                $other=(float)$request->otherExp[$i];

                $totalDeduction += $deduction;

                WageBreakingDc::create([

                    'b_no'=>$b_no,
                    'employee_id'=>$employeeId,
                    'previous_loan'=>$request->previous_loan[$i],
                    'deduction'=>$deduction,
                    'remaining_loan'=>$request->remaining[$i],
                    'other_exp'=>$other,
                    'description'=>$request->description[$i],
                    'total_amount'=>$totalAmount,
                    'date'=>$request->date,
                    'prepared_by'=>$request->prepared_by,
                    'v_type'=>'Breaking DC'

                ]);

                TRNDTL::create([
                    'v_no'=>$b_no,
                    'date'=>$request->date,
                    'description'=>'Wage breaking Dc Deduction',
                    'account_id'=>$employee->advance_cad,
                    'credit'=>$deduction,
                    'debit'=>0,
                    'preparedby'=>auth()->user()->name,
                    'status'=>'unofficial',
                    'v_type'=>'Wage Breaking DC'
                ]);
                

                TRNDTL::create([
                    'v_no'=>$b_no,
                    'date'=>$request->date,
                    'description'=>$request->description[$i],
                    'account_id'=>$employee->cad,
                    'credit'=>$other,
                    'debit'=>0,
                    'preparedby'=>auth()->user()->name,
                    'status'=>'unofficial',
                    'v_type'=>'Wage Breaking DC'
                ]);
$remaining=$totalAmount-$deduction + $other;
                TRNDTL::create([
                    'v_no'=>$b_no,
                    'date'=>$request->date,
                    'description'=>'Wage Deduction DC after deduction',
                    'account_id'=>$employee->cad,
                    'credit'=>$remaining,
                    'debit'=>0,
                    'preparedby'=>auth()->user()->name,
                    'status'=>'unofficial',
                    'v_type'=>'Wage Breaking DC'
                ]);

            }

        }

        // TRNDTL::create([
        //     'v_no'=>$b_no,
        //     'date'=>$request->date,
        //     'description'=>'Wage Breaking DC',
        //     'account_id'=>$acc_id,
        //     'credit'=>$totalAmount-$totalDeduction,
        //     'debit'=>0,
        //     'preparedby'=>auth()->user()->name,
        //     'status'=>'unofficial',
        //     'v_type'=>'Wage Breaking DC',
        //     'r_id'=>$first?->id
        // ]);

    });

    return redirect()
        ->route('breaking_wage_dc.report')
        ->with('success','Voucher updated successfully.');
}
public function report(Request $request)
{
    $validated = $request->validate([
        'start_date' => 'nullable|date',
        'end_date'   => 'nullable|date|after_or_equal:start_date',
        'status'     => 'nullable|string',
        'batch_no'   => 'nullable|string',
        'product'    => 'nullable|string',
        'employee'   => 'nullable|string',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Main query
    |--------------------------------------------------------------------------
    */

    $query = WageBreakingDc::query();

    /*
    |--------------------------------------------------------------------------
    | Date filter
    |--------------------------------------------------------------------------
    */

    if (!empty($validated['start_date'])) {
        $query->whereDate('date', '>=', $validated['start_date']);
    }

    if (!empty($validated['end_date'])) {
        $query->whereDate('date', '<=', $validated['end_date']);
    }

    /*
    |--------------------------------------------------------------------------
    | Status filter
    |--------------------------------------------------------------------------
    */

    if (!empty($validated['status'])) {
        $query->where('status', $validated['status']);
    }

    /*
    |--------------------------------------------------------------------------
    | Batch filter
    |--------------------------------------------------------------------------
    */
    // dd($validated['batch_no']);

    if (!empty($validated['batch_no'])) {
        $query->where('batch_no', $validated['batch_no']);
    }
//     dd(
//     $validated['batch_no'],
//     $query->toSql(),
//     $query->getBindings(),
//     $query->get()
// );

    /*
    |--------------------------------------------------------------------------
    | Product filter
    |--------------------------------------------------------------------------
    */

    if (!empty($validated['product'])) {
        $query->where('prod_id', $validated['product']);
    }

    /*
    |--------------------------------------------------------------------------
    | Voucher filter
    |--------------------------------------------------------------------------
    */

    if ($request->filled('v_no')) {

        [$dcType, $bNo] = explode('|', $request->v_no);

        $query->where('dc_type', $dcType)
              ->where('b_no', $bNo);
    }

    /*
    |--------------------------------------------------------------------------
    | Employee filter
    |--------------------------------------------------------------------------
    |
    | Employee is stored directly in WageBreakingDc.employee_id.
    |
    */

    if (!empty($validated['employee'])) {

        $query->whereHas('employee', function ($q) use ($validated) {
            $q->where('id', $validated['employee']);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Get records
    |--------------------------------------------------------------------------
    |
    | Load employee relationship directly from WageBreakingDc.
    |
    */

    $WageBreakings = $query
        ->with('employee')
        ->orderByDesc('id')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Get all employees for each voucher
    |--------------------------------------------------------------------------
    */

    $employeeRows = WageBreakingDc::with('employee')
        ->whereNotNull('employee_id')
        ->whereIn(
            'b_no',
            $WageBreakings->pluck('b_no')->unique()
        )
        ->get()
        ->groupBy('b_no');

    /*
    |--------------------------------------------------------------------------
    | Prepare report data
    |--------------------------------------------------------------------------
    */

    $WageBreakings->each(function ($item) use ($employeeRows) {

        /*
        | Total deduction for this voucher
        */

        $item->total_deduction = WageBreakingDc::where(
            'b_no',
            $item->b_no
        )->sum('deduction');


        /*
        | Get all employees belonging to this voucher
        */

        $rows = $employeeRows->get($item->b_no, collect());

        $item->employee_rows = $rows;

        /*
        | Employee names for report column
        */

        $item->employee_names = $rows
            ->filter(function ($row) {
                return $row->employee !== null;
            })
            ->map(function ($row) {
                return trim(
                    $row->employee->fname . ' ' .
                    $row->employee->lname
                );
            })
            ->unique()
            ->values()
            ->implode(', ');

        /*
        | First employee ID
        |
        | Useful if you need it elsewhere.
        */

        $item->employee_id = $rows
            ->pluck('employee_id')
            ->filter()
            ->first();
    });


    /*
    |--------------------------------------------------------------------------
    | Voucher list
    |--------------------------------------------------------------------------
    */

    $vNoList = WageBreakingDc::select(
            'b_no',
            'dc_type'
        )
        ->distinct()
        ->orderBy('b_no', 'desc')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Batch dropdown
    |--------------------------------------------------------------------------
    */

    $batchList = WageBreakingDc::select('batch_no')
        ->whereNotNull('batch_no')
        ->where('batch_no', '!=', '')
        ->distinct()
        ->orderBy('batch_no')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Product dropdown
    |--------------------------------------------------------------------------
    */

    $productList = WageBreakingDc::select(
            'product_name',
            'prod_id'
        )
        ->whereNotNull('product_name')
        ->where('product_name', '!=', '')
        ->distinct()
        ->orderBy('product_name')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Employee dropdown
    |--------------------------------------------------------------------------
    |
    | Same employees used in edit page.
    | Department = 20
    |
    */

    $employeeList = Employees::whereHas('employeeType', function ($query) {
        $query->where('department_id', 12);
    })
    ->orderBy('fname')
    ->orderBy('lname')
    ->get();


    /*
    |--------------------------------------------------------------------------
    | Grand total
    |--------------------------------------------------------------------------
    */

    $grandTotal = $WageBreakings->sum(function ($item) {

        return ($item->total_amount ?? 0)
             - ($item->total_deduction ?? 0);
    });


    /*
    |--------------------------------------------------------------------------
    | Return view
    |--------------------------------------------------------------------------
    */

    return view(
        'wages.breaking.index',
        compact(
            'WageBreakings',
            'vNoList',
            'batchList',
            'productList',
            'employeeList',
            'grandTotal'
        )
    );
}
  public function destroy($id)
{
    try {

        DB::transaction(function () use ($id) {

            $wageCorrugationDc = WageBreakingDc::findOrFail($id);

            $bNo = $wageCorrugationDc->b_no;

            // Delete all DC wage rows of same voucher
            WageBreakingDc::where('b_no', $bNo)->delete();

            // Delete associated transaction
            TRNDTL::where('v_no', $bNo)
                ->where('v_type', 'Wage Breaking DC')
                ->delete();
        });

        return redirect()
            ->route('breaking_wage_dc.report')
            ->with('success', 'Breaking DC wage entries deleted successfully.');

    } catch (\Exception $e) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Error deleting Breaking DC wage entries: ' . $e->getMessage()
            );
    }
}

public function print($b_no)
{
    $voucher = WageBreakingDc::where('b_no', $b_no)->firstOrFail();

    // Product Summary
    $products = WageBreakingDc::where('b_no', $b_no)
    ->whereNull('employee_id')
    ->orderBy('id')
    ->get();

    // Employee Section
    $employees = WageBreakingDc::with('employee')
        ->where('b_no', $b_no)
        ->whereNotNull('employee_id')
        ->get();

        $depcontractor = EmployeeType::where('department_id', 12)
            ->where('designation_id', 10)
            ->firstOrFail();
        // dd($contractor);

        $contractorAccountId = $depcontractor->cnic_no;
        $acc=Employees::where('id',$contractorAccountId)->firstOrFail();
        $acc_id=$acc->cad;
        $contractor= TRNDTL::with('accounts')->where('v_no', $b_no)
                ->where('v_type', 'Wage Breaking DC')
                ->where('account_id', $acc_id)
                ->first();

    return view(
        'wages.breaking.print',
        compact('voucher', 'products', 'employees','contractor')
    );
}

public function getProductVoucher(Request $request)
{
    $productId = $request->product_id;
    $batchNo   = $request->batch_no;
    $type      = $request->type;

    $startDate = Carbon::create(2026, 7, 25)->startOfDay();
    $endDate   = Carbon::today()->endOfDay();

    $rows = [];

    /*
    |--------------------------------------------------------------------------
    | Pharma DC
    |--------------------------------------------------------------------------
    */
    if ($type == 'pharma') {

        $masters = DeliveryMaster::with([
            'accounts',
            'deliveryDetails.products'
        ])
        ->where('v_type', 'PDC')

        // Date restriction
        ->whereDate('date', '>=', $startDate)
        ->whereDate('date', '<=', $endDate)

        ->whereHas('deliveryDetails', function ($q) use ($productId, $batchNo) {

            $q->where('product_name', $productId)
              ->where('batch_no', $batchNo);

        })
        ->get();

        foreach ($masters as $master) {

            $detail = $master->deliveryDetails;

            if (!$detail) {
                continue;
            }

            $product = ProductMaster::find($detail->product_name);

            $rows[] = [

                'v_no' => $master->v_no,
                'date' => $master->date,
                'account_id' => $master->account_id,
                'account_name' => $master->accounts?->title,
                'product_name' => $product?->prod_name,
                'batch_no' => $detail->batch_no,
                'qty' => ($detail->pack_qty ?? 0) * ($detail->box ?? 0),
                'type' => 'pharma',
                'prod_id' => $detail->product_name,
                'clabour' => $product?->breaking_rate ?? 0,

            ];
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Confectionery DC
    |--------------------------------------------------------------------------
    */
    else {

        $masters = ConfectioneryMaster::with([
            'accounts',
            'confectioneryDetails.products'
        ])
        ->where('v_type', 'CDC')

        // Date restriction
        ->whereDate('date', '>=', $startDate)
        ->whereDate('date', '<=', $endDate)

        ->whereHas('confectioneryDetails', function ($q) use ($productId, $batchNo) {

            $q->where('product_name', $productId)
              ->where('po_no', $batchNo);

        })
        ->get();

        foreach ($masters as $master) {

            $detail = $master->confectioneryDetails;

            if (!$detail) {
                continue;
            }

            $product = ProductMaster::find($detail->product_name);

            $rows[] = [

                'v_no' => $master->v_no,
                'date' => $master->date,
                'account_id' => $master->account_id,
                'account_name' => $master->accounts?->title,
                'product_name' => $product?->prod_name,
                'batch_no' => $detail->po_no,
                'qty' => ($detail->pack_qty ?? 0) * ($detail->box ?? 0),
                'type' => 'confectionery',
                'prod_id' => $detail->product_name,
                'clabour' => $product?->breaking_rate ?? 0,

            ];
        }
    }

    return response()->json($rows);
}
}
