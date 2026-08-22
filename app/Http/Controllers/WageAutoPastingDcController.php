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
use App\Models\WageAutoPastingDc;
use App\Models\CorrugationMaster;
use App\Models\DeliveryMaster;
use App\Models\ConfectioneryMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WageAutoPastingDcController extends Controller
{
public function index()
{
    $loggedInUser = auth()->user();

    // Last Saturday to Today
     $today = Carbon::today();
$startDate = Carbon::create(2026, 7, 25)->startOfDay();

$endDate = Carbon::today()->endOfDay();

    // Already used vouchers
    // Already used vouchers (v_no + dc_type)
$usedVouchers = WageAutoPastingDc::select('v_no', 'dc_type')
    ->distinct()
    ->get()
    ->map(function ($row) {
        return strtolower(trim($row->dc_type)) . '-' . trim($row->v_no);
    })
    ->toArray();
    // Pharma DCs
 $pharmaDC = DeliveryMaster::with([
        'accounts',
        'deliveryDetails.products'
    ])
    ->where('v_type', 'PDC')
    ->whereBetween('date', [$startDate, $endDate])
    ->get()
    ->filter(function ($dc) {

    if (!$dc->deliveryDetails) {
        return false;
    }

    $prodId = $dc->deliveryDetails->product_name;

    $product = ProductMaster::find($prodId);

    if (!$product || $product->auto_pasting != 1) {
        return false;
    }

    $alreadyUsed = WageAutoPastingDc::where([
        'dc_type' => 'pharma',
        'v_no'    => $dc->v_no,
        'prod_id' => $prodId,
    ])->exists();

    return !$alreadyUsed;
})
    ->sortByDesc('date')
    ->unique('v_no')
    ->values()
    ->map(function ($dc) {
        return [
            'v_no'  => $dc->v_no,
            'date'  => $dc->date,
            'party' => optional($dc->accounts)->title,
            'type'  => 'pharma',
        ];
    });


    // Confectionery DCs
  $confectioneryDC = ConfectioneryMaster::with([
        'accounts',
        'confectioneryDetails.products'
    ])
    ->where('v_type', 'CDC')
    ->whereBetween('date', [$startDate, $endDate])
    ->get()
->filter(function ($dc) {

    if (!$dc->confectioneryDetails) {
        return false;
    }

    $prodId = $dc->confectioneryDetails->product_name;

    $product = ProductMaster::find($prodId);

    if (!$product || $product->auto_pasting != 1) {
        return false;
    }

    $alreadyUsed = WageAutoPastingDc::where([
        'dc_type' => 'confectionery',
        'v_no'    => $dc->v_no,
        'prod_id' => $prodId,
    ])->exists();

    return !$alreadyUsed;
})
    ->sortByDesc('date')
    ->unique('v_no')
    ->values()
    ->map(function ($dc) {
        return [
            'v_no'  => $dc->v_no,
            'date'  => $dc->date,
            'party' => optional($dc->accounts)->title,
            'type'  => 'confectionery',
        ];
    });

    $deliverychallans = $pharmaDC
        ->concat($confectioneryDC)
        ->sortByDesc('date')
        ->values();
$employees = Employees::whereHas('employeeType', function ($query) {
    $query->where('department_id', 19);
})->get();

    return view(
        'wages.auto_pasting.list',
        compact('loggedInUser', 'deliverychallans','employees')
    );
}

public function edit($b_no)
{
    $loggedInUser = auth()->user();

    $voucher = WageAutoPastingDc::where('b_no', $b_no)->firstOrFail();

    // DC rows only
    $entries = WageAutoPastingDc::where('b_no', $b_no)
        ->whereNotNull('v_no')
        ->get();

    // Employee rows only
    $employeeRows = WageAutoPastingDc::where('b_no', $b_no)
        ->whereNotNull('employee_id')
        ->get();

    // Employees
    $employees = Employees::whereHas('employeeType', function ($query) {
        $query->where('department_id', 19);
    })->get();

    // Delivery Challans except already used
    // Already used vouchers except current voucher (v_no + dc_type)
$usedVouchers = WageAutoPastingDc::where('b_no', '!=', $b_no)
    ->select('v_no', 'dc_type')
    ->distinct()
    ->get()
    ->map(function ($row) {
        return strtolower(trim($row->dc_type)) . '-' . trim($row->v_no);
    })
    ->toArray();

    $today = Carbon::today();
$startDate = Carbon::create(2026, 7, 25)->startOfDay();

    $endDate = Carbon::today()->endOfDay();

   $pharmaDC = DeliveryMaster::with([
        'accounts',
        'deliveryDetails.products'
    ])
    ->where('v_type', 'PDC')
    ->whereBetween('date', [$startDate, $endDate])
    ->get()
->filter(function ($dc) {

    if (!$dc->deliveryDetails) {
        return false;
    }

    $prodId = $dc->deliveryDetails->product_name;

    $product = ProductMaster::find($prodId);

    if (!$product || $product->auto_pasting != 1) {
        return false;
    }

    $alreadyUsed = WageAutoPastingDc::where([
        'dc_type' => 'pharma',
        'v_no'    => $dc->v_no,
        'prod_id' => $prodId,
    ])->exists();

    return !$alreadyUsed;
})
    ->sortByDesc('date')
    ->unique('v_no')
    ->values()
    ->map(function ($dc) {
        return [
            'v_no'  => $dc->v_no,
            'date'  => $dc->date,
            'party' => optional($dc->accounts)->title,
            'type'  => 'pharma',
        ];
    });

$confectioneryDC = ConfectioneryMaster::with([
        'accounts',
        'confectioneryDetails.products'
    ])
    ->where('v_type', 'CDC')
    ->whereBetween('date', [$startDate, $endDate])
   ->get()
->filter(function ($dc) {

    if (!$dc->confectioneryDetails) {
        return false;
    }

    $prodId = $dc->confectioneryDetails->product_name;

    $product = ProductMaster::find($prodId);

    if (!$product || $product->auto_pasting != 1) {
        return false;
    }

    $alreadyUsed = WageAutoPastingDc::where([
        'dc_type' => 'confectionery',
        'v_no'    => $dc->v_no,
        'prod_id' => $prodId,
    ])->exists();

    return !$alreadyUsed;
})
    ->sortByDesc('date')
    ->unique('v_no')
    ->values()
    ->map(function ($dc) {
        return [
            'v_no'  => $dc->v_no,
            'date'  => $dc->date,
            'party' => optional($dc->accounts)->title,
            'type'  => 'confectionery',
        ];
    });

    $deliverychallans = $pharmaDC
        ->concat($confectioneryDC)
        ->sortByDesc('date')
        ->values();

    return view(
        'wages.auto_pasting.edit',
        compact(
            'voucher',
            'entries',
            'employeeRows',
            'employees',
            'loggedInUser',
            'deliverychallans'
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
            ->where('v_type','Wage Auto Pasting DC')
            ->delete();

        WageAutoPastingDc::where('b_no',$b_no)->delete();

        $contractor = EmployeeType::where('department_id',19)
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

            $amount = $qty * $rate;

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

            $row=WageAutoPastingDc::create([
                'b_no'=>$b_no,
                'v_no'=>$entry['v_no'],
                'dc_date'=>$entry['dc_date'],
                'account_id'=>$entry['account_id'],
                'prod_id'=>$entry['prod_id'],
                'product_name'=>$entry['product_name'],
                'batch_no'=>$entry['batch_no'],
                'qty'=>$entry['qty'],
                'clabour'=>$entry['clabour'],
                'autopasting_wage'=>$entry['breaking_wage'],
                'total_amount'=>$totalAmount,
                'dc_type'=>$entry['dc_type'],
                'date'=>$request->date,
                'prepared_by'=>$request->prepared_by,
                'v_type'=>'Auto Pasting DC'
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

                WageAutoPastingDc::create([

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
                    'v_type'=>'Auto Pasting DC'

                ]);

                TRNDTL::create([
                    'v_no'=>$b_no,
                    'date'=>$request->date,
                    'description'=>'Wage Auto Pasting Dc Deduction',
                    'account_id'=>$employee->advance_cad,
                    'credit'=>$deduction,
                    'debit'=>0,
                    'preparedby'=>auth()->user()->name,
                    'status'=>'unofficial',
                    'v_type'=>'Wage Auto Pasting DC'
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
                    'v_type'=>'Wage Auto Pasting DC'
                ]);

            }

        }

        TRNDTL::create([
            'v_no'=>$b_no,
            'date'=>$request->date,
            'description'=>'Auto Pasting DC Wage',
            'account_id'=>$acc_id,
            'credit'=>$totalAmount-$totalDeduction,
            'debit'=>0,
            'preparedby'=>auth()->user()->name,
            'status'=>'unofficial',
            'v_type'=>'Wage Auto Pasting DC',
            'r_id'=>$first?->id
        ]);

    });

    return redirect()
        ->route('autoPasting_wage_dc.report')
        ->with('success','Voucher updated successfully.');
}

public function getVoucherDetails($type, $v_no)
{
    $rows = [];

    // Date range: 25 July 2026 to today
    $startDate = Carbon::create(2026, 7, 25)->startOfDay();
    $endDate   = Carbon::today()->endOfDay();

    /*
    |--------------------------------------------------------------------------
    | Pharma DC
    |--------------------------------------------------------------------------
    */
    if ($type === 'pharma') {

        $masters = DeliveryMaster::with([
            'accounts',
            'deliveryDetails.products'
        ])
        ->where('v_no', $v_no)
        ->where('v_type', 'PDC')
        ->whereBetween('date', [$startDate, $endDate])
        ->get();

        foreach ($masters as $master) {

            $details = $master->deliveryDetails;

            if (!$details) {
                continue;
            }

            $prodId = $details->product_name;

            $product = ProductMaster::find($prodId);

            // Only manual-pasting products
            if (!$product || $product->auto_pasting != 1) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Important:
            | Check whether this SAME DC + SAME PRODUCT has already
            | been used in Manual Pasting DC.
            |--------------------------------------------------------------------------
            */
            $alreadyUsed = WageAutoPastingDc::where('dc_type', 'pharma')
                ->where('v_no', $master->v_no)
                ->where('prod_id', $prodId)
                ->exists();

            /*
            |--------------------------------------------------------------------------
            | If already used, don't return it
            |--------------------------------------------------------------------------
            */
            if ($alreadyUsed) {
                continue;
            }

            $clabour = $product->auto_pasting_rate ?? 0;

            $rows[] = [
                'v_no'          => $master->v_no,
                'date'          => $master->date,
                'account_id'    => $master->account_id,
                'account_name'  => $master->accounts?->title ?? 'N/A',
                'product_name'  => $product->prod_name ?? 'N/A',
                'batch_no'      => $details->batch_no,
                'qty'           => ($details->pack_qty ?? 0) * ($details->box ?? 0),
                'type'          => 'pharma',
                'prod_id'       => $prodId,
                'clabour'       => $clabour,
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Confectionery DC
    |--------------------------------------------------------------------------
    */
    elseif ($type === 'confectionery') {

        $masters = ConfectioneryMaster::with([
            'accounts',
            'confectioneryDetails.products'
        ])
        ->where('v_no', $v_no)
        ->where('v_type', 'CDC')
        ->whereBetween('date', [$startDate, $endDate])
        ->get();

        foreach ($masters as $master) {

            $details = $master->confectioneryDetails;

            if (!$details) {
                continue;
            }

            $prodId = $details->product_name;

            $product = ProductMaster::find($prodId);

            // Only manual-pasting products
            if (!$product || $product->auto_pasting != 1) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Important:
            | Check whether this SAME DC + SAME PRODUCT has already
            | been used in Manual Pasting DC.
            |--------------------------------------------------------------------------
            */
            $alreadyUsed = WageAutoPastingDc::where('dc_type', 'confectionery')
                ->where('v_no', $master->v_no)
                ->where('prod_id', $prodId)
                ->exists();

            /*
            |--------------------------------------------------------------------------
            | If already used, don't return it
            |--------------------------------------------------------------------------
            */
            if ($alreadyUsed) {
                continue;
            }

            $clabour = $product->auto_pasting_rate ?? 0;

            $rows[] = [
                'v_no'          => $master->v_no,
                'date'          => $master->date,
                'account_id'    => $master->account_id,
                'account_name'  => $master->accounts?->title ?? 'N/A',
                'product_name'  => $product->prod_name ?? 'N/A',
                'batch_no'      => $details->po_no,
                'qty'           => ($details->pack_qty ?? 0) * ($details->box ?? 0),
                'type'          => 'confectionery',
                'prod_id'       => $prodId,
                'clabour'       => $clabour,
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

        $contractor = EmployeeType::where('department_id', 19)
            ->where('designation_id', 10)
            ->firstOrFail();
        // dd($contractor);

        $contractorAccountId = $contractor->cnic_no;
        $acc=Employees::where('id',$contractorAccountId)->firstOrFail();
        $acc_id=$acc->cad;
        // dd($acc_id->cad);
        $lastEntry = WageAutoPastingDc::orderByDesc('b_no')->first();
        $newInvoiceNumber = $lastEntry
            ? ((int) $lastEntry->b_no + 1)
            : 1;


        $entries = [];
        $totalAmount = 0;
        $totalDeduction=0;
        $totalOtherExp=0;

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
                'autopasting_wage' => $amount,
                'dc_type' => $request->dc_type[$index],
            ];
        }

        $firstEntry = null;

        foreach ($entries as $entry) {

            $wage = WageAutoPastingDc::create([
                'b_no' => $newInvoiceNumber,
                'v_no' => $entry['v_no'],
                'dc_date' => $entry['dc_date'],
                'account_id' => $entry['account_id'],
                'prod_id' => $entry['prod_id'],
                'product_name' => $entry['product_name'],
                'batch_no' => $entry['batch_no'],
                'qty' => $entry['qty'],
                'clabour' => $entry['clabour'],
                'autopasting_wage' => $entry['autopasting_wage'],
                'total_amount' => $totalAmount,
                'dc_type' => $entry['dc_type'],
                'date' => $request->date,
                'prepared_by' => $request->prepared_by,
                'v_type' => 'Auto Pasting DC',
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
        WageAutoPastingDc::create([
            'b_no'            => $newInvoiceNumber,
            'employee_id'     => $employeeId,
            'previous_loan'   => $previousLoan,
            'deduction'       => $deduction,
            'remaining_loan'  => $remainingLoan,
            'total_amount'    => $totalAmount,
            'date'            => $request->date,
            'prepared_by'     => $request->prepared_by,
            'v_type'          => 'Wage Auto Pasting DC',
            'other_exp'       => $otherExp,
            'description'     =>$description
        ]);

        // Employee Loan Credit Entry
        TRNDTL::create([
            'v_no'        => $newInvoiceNumber,
            'date'        => $request->date,
            'description' => 'Wage Auto Pasting Dc Deduction ',
            'account_id'  => $employee->advance_cad,
            'cash_id'     => null,
            'preparedby'  => auth()->user()->name,
            'debit'       => 0,
            'credit'      => $deduction,
            'status'      => 'unofficial',
            'v_type'      => 'Wage Auto Pasting DC',
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
            'v_type'      => 'Wage Auto Pasting DC',
        ]);
    }
}
$contractorAmount = $totalAmount - $totalDeduction;
        TRNDTL::create([
            'v_no' => $newInvoiceNumber,
            'date' => $request->date,
            'description' => 'Auto Pasting DC Wage',
            'account_id' => $acc_id,
            'cash_id' => null,
            'preparedby' => auth()->user()->name,
            'credit' => $contractorAmount,
            'debit' => 0,
            'status' => 'unofficial',
            'v_type' => 'Wage Auto Pasting DC',
            'r_id' => $firstEntry?->id,
        ]);
    });

    return redirect()
        ->route('autoPasting_wage_dc.report')
        ->with('success', 'Auto Pasting DC wage stored successfully.');
}

    public function report(Request $request)
{
    $validated = $request->validate([
        'start_date' => 'nullable|date',
        'end_date'   => 'nullable|date|after_or_equal:start_date',
        'status'     => 'nullable|string',
    ]);

    $query = WageAutoPastingDc::query();

    if (!empty($validated['start_date'])) {
        $query->whereDate('date', '>=', $validated['start_date']);
    }

    if (!empty($validated['end_date'])) {
        $query->whereDate('date', '<=', $validated['end_date']);
    }

    if (!empty($validated['status'])) {
        $query->where('status', $validated['status']);
    }

    if ($request->filled('v_no')) {

        [$dcType, $bNo] = explode('|', $request->v_no);

        $query->where('dc_type', $dcType)
              ->where('b_no', $bNo);
    }

    $WageAutoPastings = $query
        ->orderByDesc('b_no')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Get contractor for each voucher
    |--------------------------------------------------------------------------
    */

    $WageAutoPastings->each(function ($item) {

        /*
        |--------------------------------------------------------------------------
        | Total deduction
        |--------------------------------------------------------------------------
        */

        $item->total_deduction = WageAutoPastingDc::where(
            'b_no',
            $item->b_no
        )->sum('deduction');


        /*
        |--------------------------------------------------------------------------
        | Get contractor from TRNDTL
        |--------------------------------------------------------------------------
        |
        | This retrieves the contractor that was saved when this
        | particular voucher was created.
        |
        */

        $contractorTransaction = TRNDTL::with('accounts')
    ->where('v_no', $item->b_no)
    ->where('v_type', 'Wage Auto Pasting DC')
    ->where('description', 'Auto Pasting DC Wage')
    ->where('credit', '>', 0)
    ->first();


        /*
        |--------------------------------------------------------------------------
        | Contractor
        |--------------------------------------------------------------------------
        */

        $item->contractor = $contractorTransaction;


        /*
        |--------------------------------------------------------------------------
        | Contractor Name
        |--------------------------------------------------------------------------
        */

        $item->contractor_name =
            $contractorTransaction?->accounts?->title ?? 'N/A';


        /*
        |--------------------------------------------------------------------------
        | Contractor Account ID
        |--------------------------------------------------------------------------
        */

        $item->contractor_account_id =
            $contractorTransaction?->account_id;
    });


    /*
    |--------------------------------------------------------------------------
    | Voucher List
    |--------------------------------------------------------------------------
    */

    $vNoList = WageAutoPastingDc::select(
            'b_no',
            'dc_type'
        )
        ->distinct()
        ->orderBy('b_no', 'desc')
        ->get();


    return view(
        'wages.auto_pasting.index',
        compact(
            'WageAutoPastings',
            'vNoList'
        )
    );
}

  public function destroy($id)
{
    try {

        DB::transaction(function () use ($id) {

            $WageAutoPastingDc = WageAutoPastingDc::findOrFail($id);

            $bNo = $WageAutoPastingDc->b_no;

            // Delete all DC wage rows of same voucher
            WageAutoPastingDc::where('b_no', $bNo)->delete();

            // Delete associated transaction
            TRNDTL::where('v_no', $bNo)
                ->where('v_type', 'Wage Auto Pasting DC')
                ->delete();
        });

        return redirect()
            ->route('autoPasting_wage_dc.report')
            ->with('success', 'Auto Pasting DC wage entries deleted successfully.');

    } catch (\Exception $e) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Error deleting Auto Pasting DC wage entries: ' . $e->getMessage()
            );
    }
}
public function print($b_no)
{
    $voucher = WageAutoPastingDc::where('b_no', $b_no)->firstOrFail();


    /*
    |--------------------------------------------------------------------------
    | Product Summary
    |--------------------------------------------------------------------------
    */

    $products = WageAutoPastingDc::select(
            'prod_id',
            'product_name',
            'clabour',
            DB::raw('GROUP_CONCAT(DISTINCT v_no ORDER BY v_no SEPARATOR ", ") as dc_no'),
            DB::raw('SUM(qty) as qty'),
            DB::raw('MAX(clabour) as rate'),
            DB::raw('SUM(autopasting_wage) as amount')
        )
        ->where('b_no', $b_no)
        ->whereNull('employee_id')
        ->groupBy(
            'prod_id',
            'product_name',
            'clabour'
        )
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Get Contractor From This Voucher's TRNDTL
    |--------------------------------------------------------------------------
    |
    | DO NOT get contractor from EmployeeType.
    |
    | The contractor account was saved in TRNDTL when this voucher
    | was created.
    |
    */

    $contractorTransaction = TRNDTL::with('accounts')
        ->where('v_no', $b_no)
        ->where('v_type', 'Wage Auto Pasting DC')
        ->where('description', 'Auto Pasting DC Wage')
        ->where('credit', '>', 0)
        ->first();


    /*
    |--------------------------------------------------------------------------
    | Contractor
    |--------------------------------------------------------------------------
    */

    $contractor = $contractorTransaction;


    /*
    |--------------------------------------------------------------------------
    | Contractor Account ID
    |--------------------------------------------------------------------------
    */

    $contractorAccountId = $contractorTransaction?->account_id;


    /*
    |--------------------------------------------------------------------------
    | Contractor Closing Balance
    |--------------------------------------------------------------------------
    */

    $contractorClosingBalance = 0;

    if ($contractorAccountId) {

        $contractorClosingBalance = TRNDTL::where(function ($query) use ($contractorAccountId) {

            $query->where('account_id', $contractorAccountId)
                  ->orWhere('cash_id', $contractorAccountId);

        })
        ->orderBy('date')
        ->orderBy('id')
        ->get()
        ->reduce(function ($balance, $trn) use ($contractorAccountId) {

            $debit = (float) $trn->debit;
            $credit = (float) $trn->credit;

            /*
            |--------------------------------------------------------------------------
            | If contractor account is on cash side,
            | reverse the effect.
            |--------------------------------------------------------------------------
            */

            if (
                $trn->cash_id == $contractorAccountId &&
                $trn->account_id != $contractorAccountId
            ) {
                $debit  = (float) $trn->credit;
                $credit = (float) $trn->debit;
            }

            return $balance + ($debit - $credit);

        }, 0);
    }


    /*
    |--------------------------------------------------------------------------
    | Employee Section
    |--------------------------------------------------------------------------
    */

    $employees = WageAutoPastingDc::with('employee')
        ->where('b_no', $b_no)
        ->whereNotNull('employee_id')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Return Print View
    |--------------------------------------------------------------------------
    */
// dd($contractor);
    return view(
        'wages.auto_pasting.print',
        compact(
            'voucher',
            'products',
            'employees',
            'contractor',
            'contractorClosingBalance'
        )
    );
}
}
