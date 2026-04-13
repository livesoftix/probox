<?php

namespace App\Http\Controllers;

use App\Models\TRNDTL;
use App\Models\ItemMaster;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use App\Models\JournalVoucher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class JournalVoucherController extends Controller
{
    public function index()
    {
        $accounts = AccountMaster::all();
        return view('journal_voucher.list', get_defined_vars());
    }
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'entry_account_title_id.*' => 'required|exists:accounts,id',
            'entry_debit' => 'required|array',
            'voucher_date' => 'required|date',
            'entry_credit' => 'required|array',
            'description' => 'nullable|array',
        ]);

        if ($request->total_debit != $request->total_credit) {
            return redirect()->back()->with('error', 'Total debit and credit amounts must be equal.');
        }

        $lastEntry = TRNDTL::where('v_type', 'JV')
            ->orderBy('id', 'desc')
            ->first();

        $lastInvoiceNumber = $lastEntry && is_numeric($lastEntry->v_no) ? (int) $lastEntry->v_no : 0;
        $newInvoiceNumber = $lastInvoiceNumber + 1;

        foreach ($request->entry_account_title as $index => $accountTitle) {
            TRNDTL::create([
                'v_no' => $newInvoiceNumber,
                'account_id' => $accountTitle,
                'status' => 'unofficial',
                'debit' => $request->entry_debit[$index] ?? 0,
                'credit' => $request->entry_credit[$index] ?? 0,
                'date' => $request->voucher_date,
                'v_type' => 'JV',
                'preparedby' => $user->name,
                'description' => $request->entry_description[$index] ?? '',
            ]);
        }

        return redirect()->route('journal_voucher.reports')->with('success', $request->v_type . '-' . $newInvoiceNumber . ' has been saved successfully.');
    }

    public function reports(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $v_no = $request->input('v_no');
        $description = $request->input('description');

        $query = TRNDTL::where('v_type', 'JV')->with('accounts');

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($v_no) {
            $query->where('v_no', $v_no);
        }
        if ($description) {
            $query->where('description', 'LIKE', "%$description%");
        }

        $trndtls = $query->orderByRaw('DATE(date) DESC')
            ->orderBy('v_no', 'desc')
            ->get();

        $vNoList = TRNDTL::where('v_type', 'JV')->pluck('v_no')->unique()->toArray();
        $descriptionList = TRNDTL::where('v_type', 'JV')->pluck('description')->unique()->toArray();
        $accountMasters = AccountMaster::all();

        return view('journal_voucher_reports.index', [
            'trndtls' => $trndtls,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'accountMasters' => $accountMasters,
            'vNoList' => $vNoList,
            'descriptionList' => $descriptionList,
        ]);
    }



    // Show the edit form for all entries of a voucher
    public function edit($v_no)
    {
        $accounts = AccountMaster::all();
        $voucher = TRNDTL::where('v_no', $v_no)->where('v_type', 'JV')->get();
        return view('journal_voucher_reports.edit', [
            'voucher' => $voucher,
            'accounts' => $accounts,
        ]);
    }

   public function update(Request $request, $v_no)
    {
        // Validate the request
        $request->validate([
            'voucher_date' => 'required|date',
            'entries' => 'required|array|min:1',
            'entries.*.id' => 'nullable|integer|exists:t_r_n_d_t_l_s,id',
            'entries.*.date' => 'required|date',
            'entries.*.account_title' => 'required|exists:account_masters,id',
            'entries.*.debit' => 'nullable|numeric|min:0',
            'entries.*.credit' => 'nullable|numeric|min:0',
            'entries.*.description' => 'nullable|string|max:255',
            'delete_entry_ids' => 'sometimes|array',
            'delete_entry_ids.*' => 'integer|exists:t_r_n_d_t_l_s,id',
        ]);

        // Calculate totals
        $debitTotal = 0;
        $creditTotal = 0;
        
        foreach ($request->entries as $entry) {
            $debitTotal += floatval($entry['debit'] ?? 0);
            $creditTotal += floatval($entry['credit'] ?? 0);
        }

        // Check if debit and credit totals are equal
        if (abs($debitTotal - $creditTotal) > 0.01) {
            return back()
                ->with('error', 'Total debit ('.number_format($debitTotal, 2).') and credit ('.number_format($creditTotal, 2).') amounts must be equal.')
                ->withInput();
        }

        $user = auth()->user();

        try {
            DB::transaction(function () use ($request, $v_no, $user) {
                // Delete entries marked for deletion
                if (!empty($request->delete_entry_ids)) {
                    TRNDTL::whereIn('id', $request->delete_entry_ids)
                        ->where('v_no', $v_no)
                        ->where('v_type', 'JV')
                        ->delete();
                }

                // Process each entry
                foreach ($request->entries as $entryData) {
                    $entryId = $entryData['id'] ?? null;
                    $debit = floatval($entryData['debit'] ?? 0);
                    $credit = floatval($entryData['credit'] ?? 0);

                    // Skip if both debit and credit are zero
                    if ($debit == 0 && $credit == 0) {
                        // If it's an existing entry with both zero, delete it
                        if ($entryId) {
                            TRNDTL::where('id', $entryId)->delete();
                        }
                        continue;
                    }

                    // Prepare data for update/insert
                    $data = [
                        'v_no'        => $v_no,
                        'account_id'  => $entryData['account_title'],
                        'debit'       => $debit,
                        'credit'      => $credit,
                        'status'      => 'unofficial',
                        'date'        => $entryData['date'],
                        'v_type'      => 'JV',
                        'preparedby'  => $user->name,
                        'description' => $entryData['description'] ?? '',
                    ];

                    if ($entryId) {
                        // Update existing entry
                        TRNDTL::where('id', $entryId)->update($data);
                    } else {
                        // Create new entry
                        TRNDTL::create($data);
                    }
                }

                // Update voucher date for all entries
                TRNDTL::where('v_no', $v_no)
                    ->where('v_type', 'JV')
                    ->update(['date' => $request->voucher_date]);
            });

            return redirect()
                ->route('journal_voucher.reports')
                ->with('success', 'JV-' . $v_no . ' has been updated successfully.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error updating voucher: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy($v_no)
    {
        // Delete all rows for the voucher number
        $exists = TRNDTL::where('v_type', 'JV')
            ->where('v_no', $v_no)
            ->exists();

        if (!$exists) {
            return redirect()->route('journal_voucher.reports')
                ->with('error', 'Voucher not found.');
        }

        DB::transaction(function () use ($v_no) {
            TRNDTL::where('v_type', 'JV')
                ->where('v_no', $v_no)
                ->delete();
        });

        return redirect()->route('journal_voucher.reports')
            ->with('success', 'JV-' . $v_no . ' has been deleted successfully!');
    }
    
     public function delete($id)
    {
        // Find the transaction by ID
        $trndtl = TRNDTL::where('v_type', 'JV')
                    ->where('id', $id)
                    ->firstOrFail();

        // Delete the transaction
        $trndtl->delete();

        // Redirect back with a success message
        return redirect()->route('journal_voucher.reports')->with('success', 'The JV transaction has been deleted successfully!');
    }
    
}
