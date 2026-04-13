<?php

namespace App\Http\Controllers;

use App\Models\DisposablePurchase;
use App\Models\TRNDTL;
use App\Models\ItemMaster;
use App\Models\AccountMaster;
use App\Models\ErpParam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DisposablePurchaseController extends Controller
{
    public function index()
    {
        $items = ItemMaster::all();
        
        $loggedInUser = Auth::user();
        $erpParam = ErpParam::first();
        
        if ($erpParam) {
            $suppliers = AccountMaster::where('level2_id', $erpParam->supplier_level)->get();
        } else {
            $suppliers = AccountMaster::all();
        }

        return view('disposable_purchase.list', compact('items', 'suppliers', 'loggedInUser'));
    }

    public function store(Request $request)
    {
        if (!$request->has('entries') || !is_array($request->entries) || count($request->entries) === 0) {
            return redirect()->back()->withInput()->with('error', 'Please add at least one entry before submitting.');
        }

        DB::beginTransaction();
        try {
            $lastEntry = TRNDTL::where('v_type', 'DSPN')
                        ->orderBy('id', 'desc')
                        ->first();

            if ($lastEntry && is_numeric($lastEntry->v_no)) {
                $voucherNo = ((int) $lastEntry->v_no) + 1;
            } else {
                $voucherNo = 1;
            }

            // Get date from request or use current date
            $date = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::now();

            foreach ($request->entries as $entryKey => $entry) {
                // Calculate amount
                $amount = ($entry['qty'] ?? 0) * ($entry['rate'] ?? 0);

                // Get item code for description
                $itemCode = DB::table('item_masters')
                    ->where('id', $entry['item_id'] ?? 0)
                    ->value('item_code');

                // Handle image upload
                $imagePath = null;
                if ($request->hasFile("entries.{$entryKey}.image")) {
                    $imagePath = $request->file("entries.{$entryKey}.image")->store('uploads', 'public');
                }

                // Save in DisposablePurchase Table
                $purchase = DisposablePurchase::create([
                    'item_id' => $entry['item_id'] ?? null,
                    'qty' => $entry['qty'] ?? 0,
                    'weight_type' => $entry['weight_type'] ?? null,
                    'rate' => $entry['rate'] ?? 0,
                    'amount' => $amount,
                    'voucher_no' => $voucherNo,
                    'freight'    => $entry['freight'] ?? 0,
                    'image' => $imagePath,
                ]);

                // Insert into TRNDTL (main entry)
                TRNDTL::create([
                    'v_no' => $voucherNo,
                    'date' => $date,
                    'account_id' => $entry['supplier'] ?? null,
                    'cash_id' => null,
                    'preparedby' => $entry['prepared_by'] ?? Auth::user()->name,
                    'debit' => 0,
                    'credit' => $amount,
                    'v_type' => 'DSPN',
                    'status' => 'unofficial',
                    'description' =>
                        ($itemCode ?? 'Item') . ' ' .
                        ($entry['qty'] ?? 0) . ' ' . 
                        ($entry['weight_type'] ?? '') . ' @ ' . 
                        ($entry['rate'] ?? 0),
                    'r_id' => $purchase->id,
                ]);

                // Insert freight entry if freight > 0
                if (($entry['freight'] ?? 0) > 0) {
                    TRNDTL::create([
                        'v_no' => $voucherNo,
                        'date' => $date,
                        'account_id' => null, // Set to appropriate account if needed
                        'cash_id' => null, // Set to appropriate cash account if needed
                        'preparedby' => $entry['prepared_by'] ?? Auth::user()->name,
                        'debit' => 0,
                        'credit' => $entry['freight'],
                        'v_type' => 'DSPN',
                        'status' => 'unofficial',
                        'description' => 'Freight',
                        'r_id' => $purchase->id,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('disposable_purchase.reports')->with('success', 'DSPN-' . $voucherNo . ' saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function reports(Request $request)
    {
        $erpParams = ErpParam::first();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $v_no = $request->input('v_no');
        $account_id = $request->input('account_id');

        $query = TRNDTL::where('v_type', 'DSPN')->where('debit', 0);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($v_no) {
            $query->where('v_no', $v_no);
        }

        if ($account_id) {
            $query->where('account_id', $account_id);
        }

        $trndtlEntries = $query->orderBy('date', 'desc')
                       ->orderBy('v_no', 'desc')
                       ->orderBy('id', 'desc')
                       ->with(['disposablepurchase.item', 'accounts'])
                       ->get();

        $accountMasters = AccountMaster::all();
        $items = ItemMaster::all();
        $vouchers = TRNDTL::where('v_type', 'DSPN')->pluck('v_no')->unique()->toArray();

        return view('disposable_purchase.reports', [
            'trndtlEntries' => $trndtlEntries,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'v_no' => $v_no,
            'account_id' => $account_id,
            'accountMasters' => $accountMasters,
            'items' => $items,
            'vouchers' => $vouchers,
            'erpParams' => $erpParams,
        ]);
    }

    public function edit($v_no)
    {
        $voucherEntries = TRNDTL::where('v_no', $v_no)
                                ->where('v_type', 'DSPN')
                                ->where('debit', 0)
                                ->with('disposablepurchase.item')
                                ->get();

        if ($voucherEntries->isEmpty()) {
            return redirect()->route('disposable_purchase.reports')->with('error', 'Voucher not found.');
        }

        $items = ItemMaster::all();
        $suppliers = AccountMaster::all();
        $loggedInUser = Auth::user();

        return view('disposable_purchase.edit', compact('v_no', 'voucherEntries', 'items', 'suppliers', 'loggedInUser'));
    }

    public function update(Request $request, $v_no)
    {
        DB::beginTransaction();

        try {
            $existingEntries = TRNDTL::where('v_no', $v_no)
                                    ->where('v_type', 'DSPN')
                                    ->where('debit', 0)
                                    ->get();

            $processedRIds = [];
            // Get date from request or use current date
            $date = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::now();

            foreach ($request->entries as $entryData) {
                $amount = ($entryData['qty'] ?? 0) * ($entryData['rate'] ?? 0);
                // Get item code for description
                $itemCode = DB::table('item_masters')
                    ->where('id', $entryData['item_id'] ?? 0)
                    ->value('item_code');

                if (isset($entryData['r_id']) && $entryData['r_id']) {
                    $purchase = DisposablePurchase::find($entryData['r_id']);
                    if (!$purchase) {
                         throw new \Exception("Purchase detail not found for ID: " . $entryData['r_id']);
                    }

                    $updateData = [
                        'item_id' => $entryData['item_id'] ?? null,
                        'qty' => $entryData['qty'] ?? 0,
                        'weight_type' => $entryData['weight_type'] ?? null,
                        'rate' => $entryData['rate'] ?? 0,
                        'amount' => $amount,
                        'freight' => $entryData['freight'] ?? 0,
                    ];
                    
                    // Handle image update
                    if ($request->hasFile("entries.{$entryData['r_id']}.image")) {
                        $imagePath = $request->file("entries.{$entryData['r_id']}.image")->store('uploads', 'public');
                        $updateData['image'] = $imagePath;
                    }
                    
                    $purchase->update($updateData);

                    TRNDTL::where('r_id', $purchase->id)
                           ->where('v_type', 'DSPN')
                           ->where('debit', 0)
                           ->update([
                               'date' => $date,
                               'account_id' => $entryData['supplier'] ?? null,
                               'preparedby' => $entryData['prepared_by'] ?? Auth::user()->name,
                               'credit' => $amount,
                               'description' =>
                                   ($itemCode ?? 'Item') . ' ' .
                                   ($entryData['qty'] ?? 0) . ' ' . 
                                   ($entryData['weight_type'] ?? '') . ' @ ' . 
                                   ($entryData['rate'] ?? 0),
                           ]);

                    // Handle freight update for existing entry
                    $freightEntry = TRNDTL::where('r_id', $purchase->id)
                        ->where('v_type', 'DSPN')
                        ->where('description', 'Freight')
                        ->first();
                    if (($entryData['freight'] ?? 0) > 0) {
                        if ($freightEntry) {
                            $freightEntry->update([
                                'credit' => $entryData['freight'],
                                'date' => $date,
                                'preparedby' => $entryData['prepared_by'] ?? Auth::user()->name,
                            ]);
                        } else {
                            TRNDTL::create([
                                'v_no' => $v_no,
                                'date' => $date,
                                'account_id' => null, // Set to appropriate account if needed
                                'cash_id' => null, // Set to appropriate cash account if needed
                                'preparedby' => $entryData['prepared_by'] ?? Auth::user()->name,
                                'debit' => 0,
                                'credit' => $entryData['freight'],
                                'v_type' => 'DSPN',
                                'status' => 'unofficial',
                                'description' => 'Freight',
                                'r_id' => $purchase->id,
                            ]);
                        }
                    } else {
                        if ($freightEntry) {
                            $freightEntry->delete();
                        }
                    }

                    $processedRIds[] = $purchase->id;

                } else {
                    $createData = [
                        'item_id' => $entryData['item_id'] ?? null,
                        'qty' => $entryData['qty'] ?? 0,
                        'weight_type' => $entryData['weight_type'] ?? null,
                        'rate' => $entryData['rate'] ?? 0,
                        'amount' => $amount,
                        'voucher_no' => $v_no,
                        'freight' => $entryData['freight'] ?? 0,
                    ];
                    
                    // Handle image for new entry
                    $entryKey = array_search($entryData, $request->entries);
                    if ($request->hasFile("entries.{$entryKey}.image")) {
                        $imagePath = $request->file("entries.{$entryKey}.image")->store('uploads', 'public');
                        $createData['image'] = $imagePath;
                    }
                    
                    $newPurchase = DisposablePurchase::create($createData);

                    TRNDTL::create([
                        'v_no' => $v_no,
                        'date' => $date,
                        'account_id' => $entryData['supplier'] ?? null,
                        'cash_id' => null,
                        'preparedby' => $entryData['prepared_by'] ?? Auth::user()->name,
                        'debit' => 0,
                        'credit' => $amount,
                        'v_type' => 'DSPN',
                        'status' => 'unofficial',
                        'description' =>
                            ($itemCode ?? 'Item') . ' ' .
                            ($entryData['qty'] ?? 0) . ' ' . 
                            ($entryData['weight_type'] ?? '') . ' @ ' . 
                            ($entryData['rate'] ?? 0),
                        'r_id' => $newPurchase->id,
                    ]);

                    if (($entryData['freight'] ?? 0) > 0) {
                        TRNDTL::create([
                            'v_no' => $v_no,
                            'date' => $date,
                            'account_id' => null, // Set to appropriate account if needed
                            'cash_id' => null, // Set to appropriate cash account if needed
                            'preparedby' => $entryData['prepared_by'] ?? Auth::user()->name,
                            'debit' => 0,
                            'credit' => $entryData['freight'],
                            'v_type' => 'DSPN',
                            'status' => 'unofficial',
                            'description' => 'Freight',
                            'r_id' => $newPurchase->id,
                        ]);
                    }

                    $processedRIds[] = $newPurchase->id;
                }
            }

            $existingRIds = $existingEntries->pluck('r_id')->toArray();
            $idsToDelete = array_diff($existingRIds, $processedRIds);

            if (!empty($idsToDelete)) {
                DisposablePurchase::whereIn('id', $idsToDelete)->delete();
                TRNDTL::whereIn('r_id', $idsToDelete)
                       ->where('v_type', 'DSPN')
                       ->where('debit', 0)
                       ->delete();
                // Also delete any freight entries for these deleted purchases
                TRNDTL::whereIn('r_id', $idsToDelete)
                       ->where('v_type', 'DSPN')
                       ->where('description', 'Freight')
                       ->delete();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => 'DSPN-' . $v_no . ' has been updated successfully.'], 200);
            }

            return back(); // Fallback for non-AJAX requests
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['error' => 'Update failed: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $trndtlEntry = TRNDTL::find($id);
        $v_no = $trndtlEntry->v_no;

        if (!$trndtlEntry) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        DB::beginTransaction();
        try {
            if ($trndtlEntry->v_type == 'DSPN' && $trndtlEntry->debit == 0) {
                $r_id = $trndtlEntry->r_id;

                if ($r_id) {
                    TRNDTL::where('r_id', $r_id)
                        ->where('v_type', 'DSPN')
                        ->delete();

                    DisposablePurchase::where('id', $r_id)->delete();
                } else {
                    $trndtlEntry->delete();
                }

                DB::commit();
                return redirect()->route('disposable_purchase.edit', $v_no)
                     ->with('success', 'Entry deleted successfully.');
            }

            $trndtlEntry->delete();
            DB::commit();
            return redirect()->route('disposable_purchase.reports')->with('success', 'Record deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        return $this->destroy($id);
    }
        public function editFreight($v_no)
    {
        // Query the TRNDTL model to find freight data for this voucher
        $freightData = TRNDTL::where('v_no', $v_no)
                             ->where('v_type', 'DSPN')
                             ->where('description', 'Freight')
                             ->first();

        // Set the freight value to 0 if no matching record is found
        $freight = $freightData ? $freightData->credit : 0;

        // Fetch the freight_type from the DisposablePurchase table (if you have such a field, otherwise skip)
        $purchase = DisposablePurchase::where('voucher_no', $v_no)->first();
        $freight_type = $purchase && isset($purchase->freight_type) ? $purchase->freight_type : null;

        // Sum the qty from DisposablePurchase for the same voucher_no
        $totalQty = DisposablePurchase::where('voucher_no', $v_no)->sum('qty');

        // Pass $freight, $v_no, $totalQty, and $freight_type to the view
        return view('disposable_purchase.editFreight', compact('freight', 'v_no', 'totalQty', 'freight_type'));
    }

    public function updateFreight(Request $request, $v_no)
    {
        // Validate the request

        $validatedData = $request->validate([
            'total_freight' => 'required|numeric|min:0',
            'freight_type' => 'nullable|string',
        ]);

        try {
            // Fetch ERP parameters if you want to use specific accounts (optional)
            $erpParam = ErpParam::first();
            $freightAccount = $erpParam ? $erpParam->pur_freight_exp : null;
            $freightCash = $erpParam ? $erpParam->pur_freight : null;

            // Check if a record with v_type == 'DSPN' and description == 'Freight' exists in TRNDTL
            $existingFreight = TRNDTL::where('v_no', $v_no)
                                     ->where('v_type', 'DSPN')
                                     ->where('description', 'Freight')
                                     ->first();


            // Check if a record with voucher_no == $v_no exists in DisposablePurchase
            $existingPurchase = DisposablePurchase::where('voucher_no', $v_no)->first();

            // If total_freight is greater than 0
            if ($validatedData['total_freight'] > 0) {
                // Update or create DisposablePurchase record (if you want to store freight at voucher level)
                if ($existingPurchase) {
                    $existingPurchase->update([
                        'freight' => $validatedData['total_freight'],
                        'freight_type' => $validatedData['freight_type'] ?? null,
                    ]);
                    $purchaseId = $existingPurchase->id;
                } else {
                    $purchase = DisposablePurchase::create([
                        'voucher_no' => $v_no,
                        'freight' => $validatedData['total_freight'],
                        'freight_type' => $validatedData['freight_type'] ?? null,
                    ]);
                    $purchaseId = $purchase->id;
                }

                // Update or create TRNDTL record
                if ($existingFreight) {
                    $existingFreight->update([
                        'credit' => $validatedData['total_freight'],
                        'preparedby' => Auth::user()->name ?? null,
                        'date' => Carbon::now(),
                        'r_id' => $purchaseId,
                        'account_id' => $freightAccount,
                        'cash_id' => $freightCash,
                    ]);
                } else {
                    TRNDTL::create([
                        'v_no' => $v_no,
                        'date' => Carbon::now(),
                        'account_id' => $freightAccount,
                        'cash_id' => $freightCash,
                        'preparedby' => Auth::user()->name ?? null,
                        'credit' => $validatedData['total_freight'],
                        'debit' => 0,
                        'status' => 'unofficial',
                        'v_type' => 'DSPN',
                        'description' => 'Freight',
                        'r_id' => $purchaseId,
                    ]);
                }
            } else {
                // If total_freight is 0, delete the existing TRNDTL record (if any)
                if ($existingFreight) {
                    $existingFreight->delete();
                }
                // If total_freight is 0, update the DisposablePurchase record (if any)
                if ($existingPurchase) {
                    $existingPurchase->update([
                        'freight' => 0,
                        'freight_type' => null,
                    ]);
                }
            }

            return redirect()->route('disposable_purchase.reports')->with('success', 'Freight updated successfully for DSPN-' . $v_no);

        } catch (\Exception $e) {
            return redirect()->route('disposable_purchase.reports')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateImage(Request $request, $id)
    {
        try {
            $purchase = DisposablePurchase::find($id);
            if (!$purchase) {
                return response()->json(['error' => 'Purchase not found'], 404);
            }

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads', 'public');
                $purchase->update(['image' => $imagePath]);
                return response()->json(['success' => 'Image updated successfully']);
            }

            return response()->json(['error' => 'No image file provided'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }
}