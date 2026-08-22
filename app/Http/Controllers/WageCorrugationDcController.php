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
use App\Models\WageCorrugationDc;
use App\Models\CorrugationMaster;
use App\Models\DeliveryMaster;
use App\Models\ConfectioneryMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WageCorrugationDcController extends Controller
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
$usedVouchers = WageCorrugationDc::select('v_no', 'dc_type')
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

    if (!$product || $product->corrugation != 1) {
        return false;
    }

    $alreadyUsed = WageCorrugationDc::where([
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

    if (!$product || $product->corrugation != 1) {
        return false;
    }

    $alreadyUsed = WageCorrugationDc::where([
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
// dd($deliverychallans);
$employees = Employees::whereHas('employeeType', function ($query) {
    $query->where('department_id', 13);
})->get();

    return view(
        'wages.corrugation.list',
        compact('loggedInUser', 'deliverychallans','employees')
    );
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
            if (!$product || $product->corrugation != 1) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Important:
            | Check whether this SAME DC + SAME PRODUCT has already
            | been used in Manual Pasting DC.
            |--------------------------------------------------------------------------
            */
            $alreadyUsed = WageCorrugationDc::where('dc_type', 'pharma')
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

            $clabour = $product->clabour ?? 0;

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
            if (!$product || $product->corrugation != 1) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Important:
            | Check whether this SAME DC + SAME PRODUCT has already
            | been used in Manual Pasting DC.
            |--------------------------------------------------------------------------
            */
            $alreadyUsed = WageCorrugationDc::where('dc_type', 'confectionery')
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

            $clabour = $product->clabour ?? 0;

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

        $contractor = EmployeeType::where('department_id', 13)
            ->where('designation_id', 10)
            ->firstOrFail();
        // dd($contractor);

        $contractorAccountId = $contractor->cnic_no;
        $acc=Employees::where('id',$contractorAccountId)->firstOrFail();
        $acc_id=$acc->cad;
        // dd($acc_id->cad);
        $lastEntry = WageCorrugationDc::orderByDesc('b_no')->first();
        $newInvoiceNumber = $lastEntry
            ? ((int) $lastEntry->b_no + 1)
            : 1;


        $entries = [];
        $totalAmount = 0;
        $totalDeduction = 0;
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
                'qty' => $qty,
                'clabour' => $clabour,
                'corrugation_wage' => $amount,
                'dc_type' => $request->dc_type[$index],
                'batch_no'  => $request->batch_no[$index],
            ];
        }

        $firstEntry = null;

        foreach ($entries as $entry) {

            $wage = WageCorrugationDc::create([
                'b_no' => $newInvoiceNumber,
                'v_no' => $entry['v_no'],
                'dc_date' => $entry['dc_date'],
                'account_id' => $entry['account_id'],
                'prod_id' => $entry['prod_id'],
                'product_name' => $entry['product_name'],
                'batch_no'     => $entry['batch_no'],
                'qty' => $entry['qty'],
                'clabour' => $entry['clabour'],
                'corrugation_wage' => $entry['corrugation_wage'],
                'total_amount' => $totalAmount,
                'dc_type' => $entry['dc_type'],
                'date' => $request->date,
                'prepared_by' => $request->prepared_by,
                'v_type' => 'Corrugation DC',
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
        WageCorrugationDc::create([
            'b_no'            => $newInvoiceNumber,
            'employee_id'     => $employeeId,
            'previous_loan'   => $previousLoan,
            'deduction'       => $deduction,
            'remaining_loan'  => $remainingLoan,
            'total_amount'    => $totalAmount,
            'date'            => $request->date,
            'prepared_by'     => $request->prepared_by,
            'v_type'          => 'Corrugation DC',
            'other_exp'       => $otherExp,
            'description'     =>$description
        ]);

        // Employee Loan Credit Entry
        TRNDTL::create([
            'v_no'        => $newInvoiceNumber,
            'date'        => $request->date,
            'description' => 'Wage Corrugation Dc Deduction ',
            'account_id'  => $employee->advance_cad,
            'cash_id'     => null,
            'preparedby'  => auth()->user()->name,
            'debit'       => 0,
            'credit'      => $deduction,
            'status'      => 'unofficial',
            'v_type'      => 'Wage Corrugation DC',
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
            'v_type'      => 'Wage Corrugation DC',
        ]);
    }
}
$contractorAmount = $totalAmount - $totalDeduction;
        TRNDTL::create([
            'v_no' => $newInvoiceNumber,
            'date' => $request->date,
            'description' => 'Corrugation DC Wage',
            'account_id' => $acc_id,
            'cash_id' => null,
            'preparedby' => auth()->user()->name,
            'credit' => $contractorAmount,
            'debit' => 0,
            'status' => 'unofficial',
            'v_type' => 'Wage Corrugation DC',
            'r_id' => $firstEntry?->id,
        ]);
    });

    return redirect()
        ->route('corrugation_wage_dc.report')
        ->with('success', 'Corrugation DC wage stored successfully.');
}

public function edit($b_no)
{
    $loggedInUser = auth()->user();

    $voucher = WageCorrugationDc::where('b_no', $b_no)->firstOrFail();

    // DC rows only
    $entries = WageCorrugationDc::where('b_no', $b_no)
        ->whereNotNull('v_no')
        ->get();

    // Employee rows only
    $employeeRows = WageCorrugationDc::where('b_no', $b_no)
        ->whereNotNull('employee_id')
        ->get();

    // Employees
    $employees = Employees::whereHas('employeeType', function ($query) {
        $query->where('department_id', 13);
    })->get();

    // Delivery Challans except already used
    // Already used vouchers except current voucher (v_no + dc_type)
$usedVouchers = WageCorrugationDc::where('b_no', '!=', $b_no)
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

    if (!$product || $product->corrugation != 1) {
        return false;
    }

    $alreadyUsed = WageCorrugationDc::where([
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

    if (!$product || $product->corrugation != 1) {
        return false;
    }

    $alreadyUsed = WageCorrugationDc::where([
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
        'wages.corrugation.edit',
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
            ->where('v_type','Wage Corrugation DC')
            ->delete();

        WageCorrugationDc::where('b_no',$b_no)->delete();

        $contractor = EmployeeType::where('department_id',13)
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
                'corrugation_wage'=>$amount,
                'dc_type'=>$request->dc_type[$i]
            ];

        }

        $first=null;

        foreach($entries as $entry){

            $row=WageCorrugationDc::create([
                'b_no'=>$b_no,
                'v_no'=>$entry['v_no'],
                'dc_date'=>$entry['dc_date'],
                'account_id'=>$entry['account_id'],
                'prod_id'=>$entry['prod_id'],
                'product_name'=>$entry['product_name'],
                'batch_no'=>$entry['batch_no'],
                'qty'=>$entry['qty'],
                'clabour'=>$entry['clabour'],
                'corrugation_wage'=>$entry['corrugation_wage'],
                'total_amount'=>$totalAmount,
                'dc_type'=>$entry['dc_type'],
                'date'=>$request->date,
                'prepared_by'=>$request->prepared_by,
                'v_type'=>'Corrugation DC'
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

                WageCorrugationDc::create([

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
                    'v_type'=>'Corrugation DC'

                ]);

                TRNDTL::create([
                    'v_no'=>$b_no,
                    'date'=>$request->date,
                    'description'=>'Wage Corrugation Dc Deduction',
                    'account_id'=>$employee->advance_cad,
                    'credit'=>$deduction,
                    'debit'=>0,
                    'preparedby'=>auth()->user()->name,
                    'status'=>'unofficial',
                    'v_type'=>'Wage Corrugation DC'
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
                    'v_type'=>'Wage Corrugation DC'
                ]);

            }

        }

        TRNDTL::create([
            'v_no'=>$b_no,
            'date'=>$request->date,
            'description'=>'Wage Corrugation DC',
            'account_id'=>$acc_id,
            'credit'=>$totalAmount-$totalDeduction,
            'debit'=>0,
            'preparedby'=>auth()->user()->name,
            'status'=>'unofficial',
            'v_type'=>'Wage Corrugation DC',
            'r_id'=>$first?->id
        ]);

    });

    return redirect()
        ->route('corrugation_wage_dc.report')
        ->with('success','Voucher updated successfully.');
}

   public function report(Request $request)
{
    $validated = $request->validate([
        'start_date' => 'nullable|date',
        'end_date'   => 'nullable|date|after_or_equal:start_date',
        'status'     => 'nullable|string',
    ]);

    $query = WageCorrugationDc::query();

    if (!empty($validated['start_date'])) {
        $query->whereDate('created_at', '>=', $validated['start_date']);
    }

    if (!empty($validated['end_date'])) {
        $query->whereDate('created_at', '<=', $validated['end_date']);
    }

    if (!empty($validated['status'])) {
        $query->where('status', $validated['status']);
    }

    if ($request->filled('v_no')) {

        [$dcType, $bNo] = explode('|', $request->v_no);

        $query->where('dc_type', $dcType)
              ->where('b_no', $bNo);
    }

    $WageCorrugations = $query
        ->orderByDesc('b_no')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Get contractor for each voucher
    |--------------------------------------------------------------------------
    |
    | Contractor is taken from TRNDTL using the voucher number.
    | This means historical vouchers keep their original contractor.
    |
    */

    $WageCorrugations->each(function ($item) {

        // Total deduction for this voucher
        $item->total_deduction = WageCorrugationDc::where(
            'b_no',
            $item->b_no
        )->sum('deduction');


        /*
        |--------------------------------------------------------------------------
        | Get contractor transaction
        |--------------------------------------------------------------------------
        */

        $contractorTransaction = TRNDTL::with('accounts')
            ->where('v_no', $item->b_no)
            ->where('v_type', 'Wage Corrugation DC')
            ->where('description', 'Wage Corrugation DC')
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
        | Contractor name
        |--------------------------------------------------------------------------
        */

        $item->contractor_name =
            $contractorTransaction?->accounts?->title ?? 'N/A';


        /*
        |--------------------------------------------------------------------------
        | Contractor account ID
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

    $vNoList = WageCorrugationDc::select(
            'b_no',
            'dc_type'
        )
        ->distinct()
        ->orderBy('b_no', 'desc')
        ->get();


    return view(
        'wages.corrugation.index',
        compact(
            'WageCorrugations',
            'vNoList'
        )
    );
}

  public function destroy($id)
{
    try {

        DB::transaction(function () use ($id) {

            $wageCorrugationDc = WageCorrugationDc::findOrFail($id);

            $bNo = $wageCorrugationDc->b_no;

            // Delete all DC wage rows of same voucher
            WageCorrugationDc::where('b_no', $bNo)->delete();

            // Delete associated transaction
            TRNDTL::where('v_no', $bNo)
                ->where('v_type', 'Wage Corrugation DC')
                ->delete();
        });

        return redirect()
            ->route('corrugation_wage_dc.report')
            ->with('success', 'Corrugation DC wage entries deleted successfully.');

    } catch (\Exception $e) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Error deleting Corrugation DC wage entries: ' . $e->getMessage()
            );
    }
}
public function closingBalance($id)
{
    $employee = Employees::findOrFail($id);

    $accountId = $employee->advance_cad;

    $closingBalance = 0;

    $transactions = DB::table('t_r_n_d_t_l_s')
        ->where(function ($q) use ($accountId) {
            $q->where('account_id', $accountId)
              ->orWhere('cash_id', $accountId);
        })
        ->whereDate('date', '<=', now()->toDateString())
        ->orderBy('date')
        ->orderBy('id')
        ->get();

    foreach ($transactions as $trn) {

        $debit = $trn->debit;
        $credit = $trn->credit;

        if ($trn->cash_id == $accountId && $trn->account_id != $accountId) {
            $debit = $trn->credit;
            $credit = $trn->debit;
        }

        $closingBalance += ($debit - $credit);
    }

    return response()->json([
        'balance' => round($closingBalance, 2)
    ]);
}

public function print($b_no)
{
    $voucher = WageCorrugationDc::where('b_no', $b_no)->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | Product Summary
    |--------------------------------------------------------------------------
    */

    $products = WageCorrugationDc::select(
            'prod_id',
            'product_name',
            'clabour',
            DB::raw('GROUP_CONCAT(DISTINCT v_no ORDER BY v_no SEPARATOR ", ") as dc_no'),
            DB::raw('SUM(qty) as qty'),
            DB::raw('MAX(clabour) as rate'),
            DB::raw('SUM(corrugation_wage) as amount')
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
    | Contractor
    |--------------------------------------------------------------------------
    |
    | Get contractor from the TRNDTL transaction saved when this
    | voucher was created.
    |
    | This means:
    |
    | Corrugation DC-1 -> Hamid
    | Corrugation DC-2 -> Haris
    |
    | Even if the current contractor has changed.
    |--------------------------------------------------------------------------
    */

    $contractorTransaction = TRNDTL::with('accounts')
        ->where('v_no', $b_no)
        ->where('v_type', 'Wage Corrugation DC')
        ->where('description', 'Wage Corrugation DC')
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
            | reverse the effect for this account.
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

    $employees = WageCorrugationDc::with('employee')
        ->where('b_no', $b_no)
        ->whereNotNull('employee_id')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Return Print View
    |--------------------------------------------------------------------------
    */

    return view(
        'wages.corrugation.print',
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
