<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\AccountMaster;
use App\Models\ItemMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

   public function index(Request $request)
{
    $query = Quotation::with('details');

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('quotation_no', 'like', "%{$search}%")
              ->orWhere('party_name', 'like', "%{$search}%");

        });
    }

    if ($request->filled('date_from')) {
        $query->whereDate('date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('date', '<=', $request->date_to);
    }

    $quotations = $query
        ->latest()
        ->paginate(20);
        // dd($quotations);
    return view('quotations.index', compact('quotations'));
}


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $parties = AccountMaster::orderBy('title')->get();

        $items = ItemMaster::orderBy('item_code')->get();

        return view('quotations.create', compact(
            'parties',
            'items'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

public function store(Request $request)
{
    $validated = $request->validate([
        'date' => 'required|date',

        'party_name' => 'required|string|max:255',

        'description' => 'nullable|string',

        'items' => 'required|array|min:1',

        'items.*.item_name' => 'required|string|max:255',

        'items.*.details' => 'nullable|string',

        'items.*.qty' => 'nullable|numeric|min:0',

        'items.*.rate' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {

        // Create quotation
        $quotation = new Quotation();

        $quotation->quotation_no =
            $this->generateQuotationNumber();

        $quotation->quotation_date =
            $validated['date'];

        $quotation->party_name =
            $validated['party_name'];

        $quotation->description =
            $validated['description'] ?? null;

        $quotation->created_by =
            Auth::user()->id;

        $quotation->updated_by =
            Auth::user()->id;
  
     $quotation->save();

// dd($validated['items']);
        // Save quotation items
        foreach ($validated['items'] as $key => $item) {

            $qty = $item['qty'] ?? null;

            $rate = $item['rate'] ?? 0;

            $amount = null;

            if ($qty !== null && $qty !== '' && $rate !== '') {
                $amount = $qty * $rate;
            }

            QuotationDetail::create([
                'quotation_id' => $quotation->id,

                'item_name' => $item['item_name'],

                'item_details' => $item['details'] ?? null,

                'qty' => $qty,

                'rate' => $rate,

                'amount' => $amount,

                'sort_order' => $key + 1,
            ]);
        }


        DB::commit();

        return redirect()
            ->route('quotations.index')
            ->with(
                'success',
                'Quotation created successfully.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with(
                'error',
                'Quotation creation failed: ' .
                $e->getMessage()
            );
    }
}

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

  public function show($id)
{
    $quotation = Quotation::with([
  'details'
    ])->findOrFail($id);

    return view('quotations.show', compact('quotation'));
}


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

   public function edit($id)
{
    $quotation = Quotation::with('details')->findOrFail($id);

    return view('quotations.edit', compact('quotation'));
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

  public function update(Request $request, $id)
{
    $validated = $request->validate([
        'date' => 'required|date',
        'party_name' => 'required|string|max:255',
        'description' => 'nullable|string',

        'items' => 'required|array|min:1',

        'items.*.item_name' => 'required|string|max:255',
        'items.*.details' => 'nullable|string',
        'items.*.qty' => 'nullable|numeric|min:0',
        'items.*.rate' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {

        $quotation = Quotation::findOrFail($id);

        $quotation->quotation_date = $validated['date'];
        $quotation->party_name = $validated['party_name'];
        $quotation->description = $validated['description'] ?? null;
        $quotation->updated_by = Auth::user()->id;

        $quotation->save();


        // Remove old details
        $quotation->details()->delete();


        // Insert updated details
        foreach ($validated['items'] as $key => $item) {

            $qty = $item['qty'] ?? null;
            $rate = $item['rate'] ?? 0;

            $amount = null;

            if ($qty !== null && $qty !== '' && $rate !== '') {
                $amount = $qty * $rate;
            }

            QuotationDetail::create([
                'quotation_id' => $quotation->id,
                'item_name' => $item['item_name'],
                'item_details' => $item['details'] ?? null,
                'qty' => $qty,
                'rate' => $rate,
                'amount' => $amount,
                'sort_order' => $key + 1,
            ]);
        }


        DB::commit();

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation updated successfully.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with(
                'error',
                'Quotation update failed: ' . $e->getMessage()
            );
    }
}


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

   public function destroy($id)
{
    DB::beginTransaction();

    try {

        $quotation = Quotation::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Delete Quotation Details
        |--------------------------------------------------------------------------
        */

        $quotation->details()->delete();


        /*
        |--------------------------------------------------------------------------
        | Delete Quotation Master
        |--------------------------------------------------------------------------
        */

        $quotation->delete();


        DB::commit();

        return redirect()
            ->route('quotations.index')
            ->with(
                'success',
                'Quotation deleted successfully.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()
            ->route('quotations.index')
            ->with(
                'error',
                'Quotation deletion failed: ' . $e->getMessage()
            );
    }
}
public function pdf($id)
{
    $quotation = Quotation::with('details')
        ->findOrFail($id);

    $pdf = Pdf::loadView(
        'quotations.pdf',
        compact('quotation')
    );

    $pdf->setPaper('A4', 'portrait');

    return $pdf->download(
        'Quotation-' . $quotation->quotation_no . '.pdf'
    );
}

    /*
    |--------------------------------------------------------------------------
    | Generate Quotation Number
    |--------------------------------------------------------------------------
    */

    private function generateQuotationNumber()
    {
        $last = Quotation::latest('id')->first();

        if (!$last) {
            return 'Q-000001';
        }

        $lastNumber = (int) preg_replace(
            '/[^0-9]/',
            '',
            $last->quotation_no
        );

        return 'Q-' .
            str_pad(
                $lastNumber + 1,
                6,
                '0',
                STR_PAD_LEFT
            );
    }
    
}