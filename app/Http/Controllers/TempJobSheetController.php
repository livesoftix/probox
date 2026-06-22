<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TempJobSheet;

class TempJobSheetController extends Controller
{
    /* -------------------------
        INDEX
    ------------------------- */
    public function index()
    {
        $loggedInUser = Auth::user();
        $jobs = TempJobSheet::orderBy('id', 'desc')->get();

        return view('temp_job_sheet.index', compact('jobs', 'loggedInUser'));
    }

    /* -------------------------
        REPORT
    ------------------------- */
   public function report(Request $request)
{
    $query = TempJobSheet::query()->with('account');

    // DATE FILTER (use actual job sheet date, not created_at)
    if ($request->start_date) {
        $query->whereDate('date', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('date', '<=', $request->end_date);
    }

    // V NO FILTER
    if ($request->v_no) {
        $query->where('v_no', $request->v_no);
    }

    // ACCOUNT FILTER
    if ($request->account_id) {
        $query->where('account_id', $request->account_id);
    }

    // ❌ REMOVE THIS (column doesn't exist)
    // if ($request->employee) {
    //     $query->where('employee_type', $request->employee);
    // }

    $generalJobSheets = $query->orderBy('id', 'desc')->get();

    // dropdown data
    $vNos = TempJobSheet::distinct()->pluck('v_no');

    $accountIds = TempJobSheet::with('account')
        ->whereNotNull('account_id')
        ->get()
        ->pluck('account.title', 'account_id')
        ->filter();

    return view('temp_job_sheet.index', compact(
        'generalJobSheets',
        'vNos',
        'accountIds'
    ));
}


    /* -------------------------
        CREATE
    ------------------------- */
    public function create()
    {
        $loggedInUser = Auth::user();

        $jobNo = (TempJobSheet::max('id') ?? 0) + 1;

        $boxboardData = DB::table('boxboard_views as b')
            ->select(
                'b.item_id',
                'i.item_code',
                'b.width',
                'b.lenght as length',
                'b.remain_qty'
            )
            ->join('item_masters as i', 'b.item_id', '=', 'i.id')
            ->get();

        return view('temp_job_sheet.list', compact(
            'loggedInUser',
            'jobNo',
            'boxboardData'
        ));
    }

    /* -------------------------
        STORE
    ------------------------- */
   public function store(Request $request)
{
    $validated = $request->validate([
        'date' => 'nullable|date',
        'job_no' => 'nullable|string',
        'job_name' => 'nullable|string',
        'size' => 'nullable|string',
        'qty' => 'nullable|numeric',

        'p_size' => 'nullable|string',
        'ream_pkt' => 'nullable|string',

        'lami' => 'nullable|string',
        'emb' => 'nullable|string',
        'varnish' => 'nullable|string',
        'colour' => 'nullable|string',
        'uv' => 'nullable|string',

        'note' => 'nullable|string',
        'm_date' => 'nullable|date',
        'e_date' => 'nullable|date',

        'box_item' => 'nullable|array',
        'box_qty' => 'nullable|array',
        'box_length' => 'nullable|array',
        'box_width' => 'nullable|array',
    ]);

    try {

        DB::beginTransaction();

        $job = new TempJobSheet();

        $job->date = $validated['date'] ?? now();

        // temp_job_sheets table uses v_no
        $job->v_no = $validated['job_no']
            ?? ((TempJobSheet::max('id') ?? 0) + 1);

        $job->job_name = $validated['job_name'] ?? null;
        $job->size = $validated['size'] ?? null;
        $job->qty = $validated['qty'] ?? 0;

        $job->p_size = $validated['p_size'] ?? null;
        $job->ream_packet = $validated['ream_pkt'] ?? null;

        $job->lamination = !empty($validated['lami']) ? 1 : 0;
        $job->embossing = !empty($validated['emb']) ? 1 : 0;
        $job->varnish = !empty($validated['varnish']) ? 1 : 0;
        $job->colour = !empty($validated['colour']) ? 1 : 0;
        $job->uv = !empty($validated['uv']) ? 1 : 0;

        $job->note = $validated['note'] ?? null;
        $job->m_date = $validated['m_date'] ?? null;
        $job->e_date = $validated['e_date'] ?? null;

        $job->created_by = Auth::id();

        $job->save();

        /* ==========================
           SAVE BOXBOARD ITEMS
        ========================== */
        if (!empty($request->box_item)) {

            foreach ($request->box_item as $key => $itemId) {

                $qty = $request->box_qty[$key] ?? 0;
                $length = $request->box_length[$key] ?? null;
                $width = $request->box_width[$key] ?? null;

                if (!empty($itemId) && $qty > 0) {

                    // item value comes like: 5_20_30
                    $parts = explode('_', $itemId);

                    DB::table('temp_job_sheet_boxboard')->insert([
                        'job_sheet_id' => $job->id,
                        'item_id' => $parts[0] ?? $itemId,
                        'length' => $length,
                        'width' => $width,
                        'qty' => $qty,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        DB::commit();

        return redirect()
            ->route('tempjob.index')
            ->with('success', 'Job Sheet created successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        dd([
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);
    }
}

    /* -------------------------
        EDIT
    ------------------------- */
    public function edit($id)
    {
        $job = TempJobSheet::findOrFail($id);
        $loggedInUser = Auth::user();

        return view('temp_job_sheet.edit', compact('job', 'loggedInUser'));
    }

    /* -------------------------
        UPDATE
    ------------------------- */
    public function update(Request $request, $id)
    {
        $job = TempJobSheet::findOrFail($id);

        $job->update($request->all());

        return redirect()
            ->route('tempjob.index')
            ->with('success', 'Updated successfully');
    }

    /* -------------------------
        DELETE
    ------------------------- */
    public function destroy($id)
    {
        TempJobSheet::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully');
    }

    /* -------------------------
        PRINT
    ------------------------- */
    public function print($id)
    {
        $job = TempJobSheet::findOrFail($id);

        return view('temp_job_sheet.print', compact('job'));
    }

    /* -------------------------
        BOXBOARD API
    ------------------------- */
    public function getboxboard()
    {
        return DB::table('boxboard_views as b')
            ->select(
                'b.item_id',
                'i.item_code',
                'b.width',
                'b.lenght as length',
                'b.remain_qty'
            )
            ->join('item_masters as i', 'b.item_id', '=', 'i.id')
            ->get();
    }
}