<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Purchase Order List
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('preparedBy')
            ->latest('id')
            ->paginate(15);

        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    /**
     * Create Purchase Order
     */
    public function create()
    {
        $poCode = $this->generatePoCode();

        return view('purchase_orders.create', compact('poCode'));
    }

    /**
     * Store Purchase Order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'party_name' => 'required|string|max:255',

            'party_address' => 'nullable|string',

            'po_date' => 'required|date',

            'delivery_date' => 'nullable|date|after_or_equal:po_date',

            'assign_to' => 'nullable|string|max:255',

            'print_by' => 'nullable|string|max:255',

            'machine_size' => [
                'required',
                'in:28 x 40,4 color,5 color,25 x 36,20 x 28',
            ],

            'items' => 'required|array|min:1',

            'items.*.item_name' => 'required|string|max:255',

            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Please add at least one item.',
            'items.*.item_name.required' => 'Item name is required.',
            'items.*.quantity.required' => 'Item quantity is required.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
        ]);

        DB::transaction(function () use ($validated, $request) {

            $totalQuantity = collect($validated['items'])
                ->sum(function ($item) {
                    return (int) $item['quantity'];
                });

            $purchaseOrder = PurchaseOrder::create([
                'po_code' => $this->generatePoCode(),

                'party_name' => $validated['party_name'],

                'party_address' => $validated['party_address'] ?? null,

                'po_date' => $validated['po_date'],

                'delivery_date' => $validated['delivery_date'] ?? null,

                'assign_to' => $validated['assign_to'] ?? null,

                'prepared_by' => auth()->id(),

                'print_by' => $validated['print_by'] ?? null,

                'machine_size' => $validated['machine_size'],

                'total_quantity' => $totalQuantity,
            ]);

            foreach ($validated['items'] as $item) {
                $purchaseOrder->items()->create([
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('purchase_orders.index')
            ->with('success', 'Purchase Order created successfully.');
    }

    /**
     * Show Purchase Order
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items', 'preparedBy');

        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    /**
     * Edit Purchase Order
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items');

        return view('purchase_orders.edit', compact('purchaseOrder'));
    }

    /**
     * Update Purchase Order
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'party_name' => 'required|string|max:255',

            'party_address' => 'nullable|string',

            'po_date' => 'required|date',

            'delivery_date' => 'nullable|date|after_or_equal:po_date',

            'assign_to' => 'nullable|string|max:255',

            'print_by' => 'nullable|string|max:255',

            'machine_size' => [
                'required',
                'in:28 x 40,4 color,5 color,25 x 36,20 x 28',
            ],

            'items' => 'required|array|min:1',

            'items.*.item_name' => 'required|string|max:255',

            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $purchaseOrder) {

            $totalQuantity = collect($validated['items'])
                ->sum(function ($item) {
                    return (int) $item['quantity'];
                });

            $purchaseOrder->update([
                'party_name' => $validated['party_name'],
                'party_address' => $validated['party_address'] ?? null,
                'po_date' => $validated['po_date'],
                'delivery_date' => $validated['delivery_date'] ?? null,
                'assign_to' => $validated['assign_to'] ?? null,
                'print_by' => $validated['print_by'] ?? null,
                'machine_size' => $validated['machine_size'],
                'total_quantity' => $totalQuantity,
            ]);

            // Remove old items
            $purchaseOrder->items()->delete();

            // Insert updated items
            foreach ($validated['items'] as $item) {
                $purchaseOrder->items()->create([
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('purchase_orders.index')
            ->with('success', 'Purchase Order updated successfully.');
    }

    /**
     * Delete Purchase Order
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return redirect()
            ->route('purchase_orders.index')
            ->with('success', 'Purchase Order deleted successfully.');
    }

    /**
     * Print Purchase Order
     */
public function print($id)
{
    $purchaseOrder = PurchaseOrder::with([
        'items',
        'preparedBy'
    ])->findOrFail($id);

    return view('purchase_orders.print', compact('purchaseOrder'));
}
    /**
     * Generate PO Code
     */
    private function generatePoCode(): string
    {
        $lastPo = PurchaseOrder::latest('id')->first();

        if (!$lastPo) {
            return 'PO-000001';
        }

        $lastNumber = (int) str_replace('PO-', '', $lastPo->po_code);

        return 'PO-' . str_pad(
            $lastNumber + 1,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}