<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use App\Models\SaleInvoice;
use App\Models\DeliveryDetail;
use App\Models\DeliveryMaster;
use App\Models\ProductMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ErpParam;
use App\Models\TRNDTL;

use Carbon\Carbon;

class DeliveryChallanController extends Controller
{
    public function index()
    {
        $loggedInUser = Auth::user();
        $accounts = AccountMaster::all();
        $items = ItemType::all();
        $product = ProductMaster::all();
        return view('sales.delivery_challan.list',get_defined_vars());
    }
    
    
public function getProducts($partyId)
{
    $products = ProductMaster::where('aid', $partyId)->get();
    return response()->json($products);
}

public function store(Request $request)
{
    // dd($request->entries);
    $maxVno = DeliveryMaster::where('v_type', 'PDC')
        ->max('v_no');

if (is_numeric($maxVno)) {
    $newInvoiceNumber = (int) $maxVno + 1;
} else {
    $newInvoiceNumber = 1; 
}
        
  
    foreach ($request->entries as $index => $entry) {
        $deliveryDetail = DeliveryDetail::create([
            'v_no' => $newInvoiceNumber,
            'item_code' => $entry['item'] ?? null,
            'product_name' => $entry['product'] ?? null,
            'batch_no' => $entry['batch_no'] ?? 0,
            'box' => $entry['box'] ?? 0,
            'pack_qty' => $entry['packing'] ?? 0,
            'total' => $entry['total'] ?? 0,
            'freight' => $entry['freight'] ?? 0,
        ]);

        DeliveryMaster::create([
            'v_no' => $newInvoiceNumber,
            'date' => Carbon::now(),
            'account_id' => $entry['supplier'] ?? null,
            'preparedby' => $entry['prepared_by'] ?? null,
            'driver_name'=>$entry['driver_name'] ?? null,
            'vehicle_number' => $entry['vehicle_number'] ?? null,
            'status' => 'unofficial',
            'v_type' => 'PDC',
            'delivery_detail_id' => $deliveryDetail->id,
        ]);
        
        $erpParam = ErpParam::first(); 
   $Salefreight = $erpParam ? $erpParam->sale_freight : null;
    $SalefreightExp = $erpParam ? $erpParam->sale_freight_exp : null;
    
        if (($entry['freight'] ?? 0) > 0) { 
    TRNDTL::create([
        'v_no' => $newInvoiceNumber,
        'date' => Carbon::now(),
        'account_id' => $SalefreightExp,
        'cash_id' => $Salefreight,
        'preparedby' => $entry['prepared_by'] ?? null,
        'credit' => $entry['freight'] ?? null,
        'debit' => '0',
        'status' => 'unofficial',
        'v_type' => 'PDC',
        'r_id' => $deliveryDetail->id,
        'description' => 'Freight',
    ]);
}

    }

    return redirect()->route('delivery_challan.reports')->with('success', "Voucher No. $newInvoiceNumber has been created successfully.");
}




public function reports(Request $request)
{
    $products = ProductMaster::all();

    // Get unique item codes from the DeliveryDetail table
    $itemCodes = DeliveryDetail::distinct()->pluck('item_code');
    $account = DeliveryMaster::distinct()->pluck('account_id');

    // Fetch only ItemType entries that are referenced in the DeliveryDetail table
    $items = ItemType::whereIn('id', $itemCodes)->get();
    $accounts = AccountMaster::whereIn('id', $account)->get();

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $status = $request->input('status');
    $itemId = $request->input('item'); // New item filter
    $accountId = $request->input('account'); // New item filter
    $po = $request->input('batch_no'); // New PO filter
    $v_no = $request->input('v_no');

    // Get unique P.O numbers
    $poNumbers = DeliveryDetail::distinct()->pluck('batch_no');

    // Build the query with date range, status, item, and PO filters
    $query = DeliveryMaster::with('deliveryDetails');

    if ($startDate && $endDate) {
        $query->whereBetween('date', [$startDate, $endDate]);
    }

    if ($status) {
        $query->where('status', $status);
    }

    if ($itemId) {
        $query->whereHas('deliveryDetails', function ($q) use ($itemId) {
            $q->where('item_code', $itemId); // Match item_code instead of type_title
        });
    }
    
    if ($accountId) {
        $query->whereHas('deliveryDetails', function ($q) use ($accountId) {
            $q->where('account_id', $accountId); // Match item_code instead of type_title
        });
    }

    if ($po) {
        $query->whereHas('deliveryDetails', function ($q) use ($po) {
            $q->where('batch_no', $po);
        });
    }

    if ($v_no) {
        $query->whereHas('deliveryDetails', function ($q) use ($v_no) {
            $q->where('v_no', $v_no);
        });
    }

    
    
    $trndtl = $query->orderByRaw('CAST(date AS DATE) DESC')
        ->orderByRaw('CAST(v_no AS SIGNED) DESC')
        ->orderBy('id', 'desc')
        ->get();

    $accountMasters = AccountMaster::all();
    $vNoList = DeliveryMaster::pluck('v_no')->unique()->toArray();
    if($v_no){
    $driverdetails = DeliveryMaster::where('v_no', $v_no)
    ->first();
}else{
    $driverdetails='';
}
// dd($driverdetails);
    

    return view('sale_reports.index', [
        'trndtl' => $trndtl,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'status' => $status,
        'accountMasters' => $accountMasters,
        'items' => $items,
        'accounts' => $accounts,
        'products' => $products,
        'itemId' => $itemId, 
        'po' => $po,
        'vNoList' => $vNoList,
        'poNumbers' => $poNumbers,
        'driverdetails'=>$driverdetails
    ]);
}




public function edit($v_no)
{
    // Check if bill exists in TRNDTL
    if (SaleInvoice::where('old_vno', $v_no)->exists()) {
        return redirect()->route('delivery_challan.reports')
            ->with('error', 'Cannot edit PDC that has a bill in TRNDTL.');
    }

    $loggedInUser = Auth::user();
    $voucher = DeliveryMaster::where('v_no', $v_no)->get();

    $rates = [];
    $billed = [];
    foreach ($voucher as $row) {
        $detail = $row->deliveryDetails;
        if ($detail) {
            $rate = SaleInvoice::where('old_vno', $v_no)
                ->when($detail->product_name, function ($q) use ($detail) {
                    $q->where('product_name', $detail->product_name);
                })
                ->when($detail->item_code, function ($q) use ($detail) {
                    $q->where('item', $detail->item_code);
                })
                ->value('rate');
            $rates[$detail->id] = $rate ?? 0;
            $hasBill = SaleInvoice::where('old_vno', $v_no)
                ->when($detail->product_name, function ($q) use ($detail) {
                    $q->where('product_name', $detail->product_name);
                })
                ->when($detail->item_code, function ($q) use ($detail) {
                    $q->where('item', $detail->item_code);
                })
                ->when($detail->batch_no, function ($q) use ($detail) {
                    $q->where('batch_no', $detail->batch_no);
                })
                ->exists();
            $billed[$detail->id] = $hasBill;
        }
    }

    $accounts = AccountMaster::all();
    $items = ItemType::all();
    $product = ProductMaster::all();
    $deliveryDetails = ConfectioneryMaster::where('v_no', $v_no)
    ->first();

    return view('sale_reports.edit', get_defined_vars());
}


public function update(Request $request, $id)
{
    $entries = $request->input('entries', []);
    if (!is_array($entries)) {
        return back()->withErrors(['entries' => 'Entries must be an array.']);
    }

    $erpParam = ErpParam::first();
    $saleFreight = $erpParam?->sale_freight;
    $saleFreightExp = $erpParam?->sale_freight_exp;

    // Check if bill exists in TRNDTL
    $hasBilling = TRNDTL::where('v_no', $id)->exists();

    // Handle deleted rows
    $deletedIds = $request->input('deleted_ids', []);
    if (is_array($deletedIds) && !empty($deletedIds)) {
        foreach ($deletedIds as $deletedId) {
            $detail = DeliveryDetail::find($deletedId);
            if ($detail) {
                

                DeliveryMaster::where('delivery_detail_id', $detail->id)
                    ->where('v_no', $id)
                    ->delete();

                TRNDTL::where('r_id', $detail->id)
                    ->where('v_no', $id)
                    ->where('v_type', 'PDC')
                    ->delete();

                $detail->delete();
            }
        }
    }


    foreach ($entries as $key => $entry) {
        $entryFreight = floatval($entry['freight'] ?? 0);
        $entryBox = intval($entry['box'] ?? 0);
        $entryPacking = intval($entry['packing'] ?? 0);
        $entryBatch = $entry['batchNo'] ?? '';
        $preparedBy = $entry['prepared_by'] ?? '';
        $entryTotal = (float) ($entryBox * $entryPacking);

        // New Entry
        if (strpos($key, 'new_') === 0) {
            

            $newDetail = DeliveryDetail::create([
                'item_code' => $entry['item'] ?? null,
                'product_name' => $entry['product'] ?? null,
                'batch_no' => $entryBatch,
                'box' => $entryBox,
                'pack_qty' => $entryPacking,
                'total' => $entryTotal,
                'v_no' => $id,
                'freight' => $entryFreight,
                
            ]);

            DeliveryMaster::create([
                'v_no' => $id,
                'date' => Carbon::now(),
                'account_id' => $entry['supplier'] ?? null,
                'preparedby' => $preparedBy,
                'driver_name'=>$entry['driver_name'] ?? null,
                'vehicle_number' => $entry['vehicle_number'] ?? null,
                'status' => 'unofficial',
                'v_type' => 'PDC',
                'delivery_detail_id' => $newDetail->id,
            ]);

            if ($entryFreight > 0) {
                TRNDTL::create([
                    'v_no' => $id,
                    'date' => Carbon::now(),
                    'account_id' => $saleFreightExp,
                    'cash_id' => $saleFreight,
                    'preparedby' => $preparedBy,
                    'credit' => $entryFreight,
                    'debit' => '0',
                    'status' => 'unofficial',
                    'v_type' => 'PDC',
                    'r_id' => $newDetail->id,
                    'description' => 'Freight',
                ]);
            }
        }
        // Existing Entry - only update if no bill exists
        else {
           

            $detail = DeliveryDetail::find($key);
            if ($detail) {
                $detail->update([
                    'item_code' => $entry['item'] ?? null,
                    'product_name' => $entry['product'] ?? null,
                    'batch_no' => $entryBatch,
                    'box' => $entryBox,
                    'pack_qty' => $entryPacking,
                    'total' => $entryTotal,
                    'freight' => $entryFreight,
                    'driver_name'=>$entry['driver_name'] ?? null,
                    'vehicle_number' => $entry['vehicle_number'] ?? null
                ]);

                DeliveryMaster::where('delivery_detail_id', $detail->id)
                    ->where('v_no', $id)
                    ->update([
                        'date' => Carbon::now(),
                        'account_id' => $entry['supplier'] ?? null,
                        'preparedby' => $preparedBy,
                        'driver_name'=>$entry['driver_name'] ?? null,
                        'vehicle_number' => $entry['vehicle_number'] ?? null
                    ]);

                if ($entryFreight > 0) {
                    $trndtl = TRNDTL::where('v_no', $id)
                        ->where('v_type', 'PDC')
                        ->where('r_id', $detail->id)
                        ->first();

                    if ($trndtl) {
                        $trndtl->update([
                            'date' => Carbon::now(),
                            'account_id' => $saleFreightExp,
                            'cash_id' => $saleFreight,
                            'preparedby' => $preparedBy,
                            'credit' => $entryFreight,
                        ]);
                    } else {
                        TRNDTL::create([
                            'v_no' => $id,
                            'date' => Carbon::now(),
                            'account_id' => $saleFreightExp,
                            'cash_id' => $saleFreight,
                            'preparedby' => $preparedBy,
                            'credit' => $entryFreight,
                            'debit' => '0',
                            'status' => 'unofficial',
                            'v_type' => 'PDC',
                            'description' => 'Freight',
                            'r_id' => $detail->id,
                        ]);
                    }
                } else {
                    TRNDTL::where('v_no', $id)
                        ->where('v_type', 'PDC')
                        ->where('r_id', $detail->id)
                        ->delete();
                }
            }
        }
    }

    return redirect()->route('delivery_challan.reports')
        ->with('success', "Voucher PDC-$id updated successfully.");
}






public function destroy($id)
{
    // Find the DeliveryMaster record by ID
    $deliveryMaster = DeliveryMaster::findOrFail($id);

    // Get the v_no and delivery_detail_id from the master record
    $vNo = $deliveryMaster->v_no;
    $detailId = $deliveryMaster->delivery_detail_id;

    // Check if a bill exists for this voucher
    if (SaleInvoice::where('old_vno', $vNo)->exists()) {
        return redirect()->back()->with('error', 'Cannot delete voucher. Please delete the related bill first.');
    }

    // Delete related DeliveryDetail records
    $deliveryMaster->deliveryDetails()->delete();

    // Delete related TRNDTL records
    TRNDTL::where('r_id', $detailId)
        ->where('v_no', $vNo)
        ->where('v_type', 'PDC')
        ->where('description', 'freight')
        ->delete();

    // Delete the DeliveryMaster record
    $deliveryMaster->delete();

    return redirect()->back()->with('success', 'Voucher deleted successfully.');
}


public function delete($id)
{
    
    return $this->destroy($id);
}




public function editCon($v_no)
{
    // 1. Get freight data from TRNDTL
    $freightData = TRNDTL::where('v_no', $v_no)
        ->where('v_type', 'PDC')
        ->where('description', 'freight')
        ->first();
    $freight = $freightData ? $freightData->credit : 0;

    // 2. Get freight_type and sum boxes (FIXED: Use correct model)
    $confectBilling = DeliveryDetail::where('v_no', $v_no)->first();
    $freight_type = $confectBilling ? $confectBilling->freight_type : null;

    // 3. Sum boxes (FIXED: Ensure correct model and column)
    $totalbox = DeliveryDetail::where('v_no', (string)$v_no)->sum('box');

    return view('sale_reports.editDelDc', compact('freight', 'v_no', 'totalbox', 'freight_type'));
}

public function updateCon(Request $request, $id)
{
    // Validate the request
    $validatedData = $request->validate([
        'total_freight' => 'required|numeric|min:0',
        'freight_type' => 'required|string', // Add validation for freight_type
    ]);

    try {
        // Fetch ERP parameters
        $erpParam = ErpParam::first();
        if (!$erpParam) {
            throw new \Exception('ERP parameters not found.');
        }

        $cashAccId = $erpParam->cash_acc;
        $Purfreight = $erpParam->sale_freight;
        $PurfreightExp = $erpParam->sale_freight_exp;
        
        $Salefreight = $erpParam ? $erpParam->sale_freight : null;
        $SalefreightExp = $erpParam ? $erpParam->sale_freight_exp : null;

        // Check if a record with v_type == 'BPN' and description == 'Freight' exists in TRNDTL
        $existingFreight = TRNDTL::where('v_no', $id)
                                 ->where('v_type', 'PDC')
                                 ->where('description', 'Freight')
                                 ->first();

        // Check if a record with vorcher_no == $id exists in PurchaseDetail
        $existingPurchaseDetail = DeliveryDetail::where('v_no', $id)->first();

        // If total_freight is greater than 0
        if ($validatedData['total_freight'] > 0) {
            // Update or create PurchaseDetail record
            if ($existingPurchaseDetail) {
                // Update the existing PurchaseDetail record
                $existingPurchaseDetail->update([
                    'freight' => $validatedData['total_freight'],
                    'freight_type' => $validatedData['freight_type'], // Add this line
                ]);

                // Get the id of the updated PurchaseDetail record
                $purchaseDetailId = $existingPurchaseDetail->id;
            } else {
                // Create a new PurchaseDetail record
                $purchaseDetail = DeliveryDetail::create([
                    'v_no' => $id,
                    'freight' => $validatedData['total_freight'],
                    'freight_type' => $validatedData['freight_type'], // Add this line
                    // Add other necessary fields here
                ]);

                // Get the id of the newly created PurchaseDetail record
                $purchaseDetailId = $purchaseDetail->id;
            }

            // Update or create TRNDTL record
            if ($existingFreight) {
                // Update the existing TRNDTL record
                $existingFreight->update([
                    'credit' => $validatedData['total_freight'],
                    'preparedby' => Auth::user()->name ?? null,
                    'date' => Carbon::now(),
                    'r_id' => $purchaseDetailId, // Set r_id to the PurchaseDetail id
                ]);
            } else {
                // Create a new TRNDTL record
                TRNDTL::create([
                    'v_no' => $id,
                    'date' => Carbon::now(),
                    'account_id' => $SalefreightExp,
                    'cash_id' => $Salefreight,
                    'preparedby' => Auth::user()->name ?? null,
                    'credit' => $validatedData['total_freight'],
                    'debit' => '0',
                    'status' => 'unofficial',
                    'v_type' => 'PDC',
                    'description' => 'Freight',
                    'r_id' => $purchaseDetailId, // Set r_id to the PurchaseDetail id
                ]);
            }
        } else {
            // If total_freight is 0, delete the existing TRNDTL record (if any)
            if ($existingFreight) {
                $existingFreight->delete();
            }

            // If total_freight is 0, update the PurchaseDetail record (if any)
            if ($existingPurchaseDetail) {
                $existingPurchaseDetail->update([
                    'freight' => 0,
                ]);
            }
        }

       return redirect()->route('delivery_challan.reports')->with('success', 'Freight updated successfully for PDC-' . $id);

    } catch (\Exception $e) {
        // Handle any exceptions and return an error message
        return redirect()->route('delivery_challan.reports')->with('error', 'An error occurred: ' . $e->getMessage());
    }
}





}
