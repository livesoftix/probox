<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackagingSpec;
use App\Models\PackagingSpecDetail;
use App\Models\ItemMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PackagingSpecController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PackagingSpec::with('details');

        // Filter by exact date (if provided)
        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        // Partial match for company name
        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', '%' . $request->input('company_name') . '%');
        }

        // Partial match for item name
        if ($request->filled('item_name')) {
            $query->where('item_name', 'like', '%' . $request->input('item_name') . '%');
        }

        $specs = $query
    ->orderBy('date', 'desc')
    ->orderBy('id', 'desc')
    ->get();

        return view('packaging_specs.index', compact('specs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ItemMasters = ItemMaster::all();
        return view('packaging_specs.create', compact('ItemMasters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'nullable|date',
            'company_name' => 'nullable|string|max:255',
            'item_name' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'die_pattern' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'lam_size' => 'nullable|string|max:255',
            'flute_size' => 'nullable|string|max:255',
            'box_type' => 'nullable|string|max:255',
            'box_type_other' => 'nullable|string|max:255',
            'printing_side' => 'nullable|string|max:255',
            'designing_color' => 'nullable|string|max:255',

            'length' => 'nullable|string|max:255',
            'width' => 'nullable|string|max:255',
            'height' => 'nullable|string|max:255',

            'glue_flap' => 'required|string|max:255',
            'holding_flap' => 'required|string|max:255',
            'pendi' => 'required|string|max:255',
            'die_grip' => 'required|string|max:255',

            // Boolean flags
            'shine_lamination' => 'nullable|boolean',
            'matte_lamination' => 'nullable|boolean',
            'uv_plain' => 'nullable|boolean',
            'uv_spot' => 'nullable|boolean',
            'uv_drip' => 'nullable|boolean',
            'window_glass' => 'nullable|boolean',
            'window_lamination' => 'nullable|boolean',
            'emboss' => 'nullable|boolean',
            'demboss' => 'nullable|boolean',
            'gold_finish' => 'nullable|boolean',
            'silver_finish' => 'nullable|boolean',

            'image_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',

            // Multiple UPS rows
            'details' => 'required|array',
            'details.*.printing_size' => 'nullable|string|max:255',
            'details.*.board_size' => 'nullable|string|max:255',
            'details.*.ups' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Handle file upload
            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $path = $file->store('uploads', 'public');
                $validated['image_path'] = $path;
            } else {
                $validated['image_path'] = null;
            }

            // Handle "Other" box type
            if (!empty($validated['box_type']) && $validated['box_type'] === 'other') {
                $validated['box_type'] = $validated['box_type_other'] ?? null;
            }
            unset($validated['box_type_other']);

            // Create the main Packaging Spec
            $spec = PackagingSpec::create($validated);

            // Create each related detail
            foreach ($validated['details'] as $detail) {
                if (!empty($detail['printing_size']) || !empty($detail['board_size']) || !empty($detail['ups'])) {
                    $spec->details()->create($detail);
                }
            }

            DB::commit();

            return redirect()
                ->route('packaging-specs.index')
                ->with('success', 'Packaging Spec created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to save packaging spec: ' . $e->getMessage()]);
        }
    }

    /**
     * Show a print-friendly view of the packaging spec.
     */
    public function print(PackagingSpec $packagingSpec)
    {
        $packagingSpec->load('details');
        return view('packaging_specs.pdf', compact('packagingSpec'));
    }

    /**
     * Remove the specified resource from storage.
     * 
     * 
     */

    public function edit (PackagingSpec $packagingSpec)
    {
        $ItemMasters = ItemMaster::all();
        $packagingSpec->load('details');
        return view('packaging_specs.edit', compact('packagingSpec', 'ItemMasters'));
    }


  public function update(Request $request, $id)
{
    $spec = PackagingSpec::with('details')->findOrFail($id);

    $validated = $request->validate([
        'date' => 'nullable|date',
        'company_name' => 'nullable|string|max:255',
        'item_name' => 'nullable|string|max:255',
         'country' => 'nullable|string|max:255',
         'die_pattern' => 'nullable|string|max:255',
        'unit' => 'nullable|string|max:255',
        'lam_size' => 'nullable|string|max:255',
        'flute_size' => 'nullable|string|max:255',
        'box_type' => 'nullable|string|max:255',
        'box_type_other' => 'nullable|string|max:255',
        'printing_side' => 'nullable|string|max:255',
        'designing_color' => 'nullable|string|max:255',

        'length' => 'nullable|string|max:255',
        'width' => 'nullable|string|max:255',
        'height' => 'nullable|string|max:255',

        'glue_flap' => 'required|string|max:255',
        'holding_flap' => 'required|string|max:255',
        'pendi' => 'required|string|max:255',
        'die_grip' => 'required|string|max:255',

        // Boolean flags
        'shine_lamination' => 'nullable|boolean',
        'matte_lamination' => 'nullable|boolean',
        'uv_plain' => 'nullable|boolean',
        'uv_spot' => 'nullable|boolean',
        'uv_drip' => 'nullable|boolean',
        'window_glass' => 'nullable|boolean',
        'window_lamination' => 'nullable|boolean',
        'emboss' => 'nullable|boolean',
        'demboss' => 'nullable|boolean',
        'gold_finish' => 'nullable|boolean',
        'silver_finish' => 'nullable|boolean',

        'image_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',

        // Multiple UPS rows
        'details' => 'required|array',
    'details.*.id' => 'nullable|integer|exists:packaging_spec_details,id',
    'details.*.printing_size' => 'nullable|string|max:255',
    'details.*.board_size' => 'nullable|string|max:255',
    'details.*.ups' => 'nullable|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        // Handle file upload replacement
        if ($request->hasFile('image_path')) {
            if ($spec->image_path && Storage::disk('public')->exists($spec->image_path)) {
                Storage::disk('public')->delete($spec->image_path);
            }
            $file = $request->file('image_path');
            $path = $file->store('uploads', 'public');
            $validated['image_path'] = $path;
        } else {
            // Keep existing image if not replaced
            $validated['image_path'] = $spec->image_path;
        }

        // Handle "Other" box type
        if (!empty($validated['box_type']) && $validated['box_type'] === 'other') {
            $validated['box_type'] = $validated['box_type_other'] ?? null;
        }
        unset($validated['box_type_other']);

        // Update main record
        $spec->update($validated);

        // Sync details
        $existingIds = $spec->details->pluck('id')->toArray();
        $incomingIds = collect($validated['details'])->pluck('id')->filter()->toArray();

        // Delete removed details
        $toDelete = array_diff($existingIds, $incomingIds);
        PackagingSpecDetail::whereIn('id', $toDelete)->delete();

        // Update or create details
        foreach ($validated['details'] as $detail) {
            if (!empty($detail['id'])) {
                // Update existing detail
                $existingDetail = $spec->details->firstWhere('id', $detail['id']);
                if ($existingDetail) {
                    $existingDetail->update($detail);
                }
            } else {
                // Create new detail
                if (!empty($detail['printing_size']) || !empty($detail['board_size']) || !empty($detail['ups'])) {
                    $spec->details()->create($detail);
                }
            }
        }

        DB::commit();

        return redirect()
            ->route('packaging-specs.index')
            ->with('success', 'Packaging Spec updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()->withErrors(['error' => 'Failed to update packaging spec: ' . $e->getMessage()]);
    }
}





    public function show(PackagingSpec $packagingSpec)
    {
        $packagingSpec->load('details');
        return view('packaging_specs.show', compact('packagingSpec'));
    }
    public function destroy($id)
    {
        $spec = PackagingSpec::findOrFail($id);

        // Delete image if exists
        if ($spec->image_path) {
            try {
                Storage::disk('public')->delete($spec->image_path);
            } catch (\Exception $e) {
                logger()->warning('Failed to delete packaging spec image: ' . $e->getMessage());
            }
        }

        // Delete related details
        $spec->details()->delete();
        $spec->delete();

        return redirect()
            ->route('packaging-specs.index')
            ->with('success', 'Packaging Spec deleted successfully.');
    }
}
