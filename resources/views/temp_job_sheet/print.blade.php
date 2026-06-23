@extends('layouts.app')

@section('content')
<style>
.a4-sheet{
    width:210mm;
    min-height:297mm;
    margin:auto;
    background:#fff;
    padding:10mm;
    border:1px solid #ddd;
}

/* =========================
   TABLE BASE STYLE
========================= */
.table-bordered{
    width:100%;
    border-collapse:collapse;
}

/* ✅ HEADINGS FIX */
.table-bordered th{
    border:1px solid #000;
    padding:6px;
    background:#fff !important;

    color:#000 !important;
    font-weight:700 !important;
    text-align:left;
}

/* ✅ TABLE CELLS */
.table-bordered td{
    border:1px solid #000;
    padding:6px;
    background:#fff !important;
    color:#000 !important;
}

/* remove striping */
.table-bordered tr{
    background:#fff !important;
}

/* =========================
   PRINT FIX
========================= */
@media print{
    .no-print{
        display:none !important;
    }

    body{
        margin:0;
        background:#fff;
        color:#000;
    }

    .a4-sheet{
        border:none;
        box-shadow:none;
        background:#fff;
    }

    table, tr, td, th{
        background:#fff !important;
        color:#000 !important;
    }

    th{
        font-weight:700 !important;
        color:#000 !important;
    }
}
</style>

<div class="container-fluid">

    <div class="mb-3 mt-5 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            Print Job Sheet
        </button>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="a4-sheet">

        <h3 class="text-center">JOB SHEET</h3>

        {{-- BASIC INFO --}}
        <table class="table-bordered">
            <tr>
                <th>Job No</th>
                <td>TJS-{{ $job->v_no }}</td>

                <th>Date</th>
                <td>
                    {{ $job->date ? \Carbon\Carbon::parse($job->date)->format('d-m-Y') : '' }}
                </td>
            </tr>

            <tr>
                <th>Job Name</th>
                <td>{{ $job->product?->prod_name }}</td>

                
            </tr>
            <tr>
                <th>Prepared By</th>
                <td>{{ $job->preparedby ?? '' }}</td>

                <th>Printing For</th>
                <td>{{ $job->printing_for ?? '' }}</td>
</tr>

            <tr>
                <th>Size</th>
                <td>{{ $job->size }}</td>

                <th>P.Size</th>
                <td>{{ $job->p_size }}</td>
            </tr>


            <tr>
                <th>M Date</th>
                <td>{{ $job->m_date }}</td>

                <th>E Date</th>
                <td>{{ $job->e_date }}</td>
            </tr>
        </table>

        <br>

        {{-- BOXBOARD --}}
        <h4>Boxboard</h4>

        <table class="table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>No of Used Rims/Pkt</th>
                </tr>
            </thead>

            <tbody>
                @forelse($job->boxboards as $key => $box)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $box->item->item_code ?? '' }}</td>
                    <td>{{ $box->length }}</td>
                    <td>{{ $box->width }}</td>
                    <td>{{ $box->qty }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No data found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <br>

        {{-- PROCESS --}}
        <h4>Process</h4>

        <table class="table-bordered">
            <tr>
                <th>Lamination</th>
                <td>{{ $job->lamination ? 'Yes' : 'No' }}</td>

                <th>Embossing</th>
                <td>{{ $job->embossing ? 'Yes' : 'No' }}</td>
            </tr>

            <tr>
                <th>Varnish</th>
                <td>{{ $job->varnish ? 'Yes' : 'No' }}</td>

                <th>Colour</th>
                <td>{{ $job->colour ? 'Yes' : 'No' }}</td>
            </tr>

            <tr>
                <th>UV</th>
                <td>{{ $job->uv ? 'Yes' : 'No' }}</td>

                <th></th>
                <td></td>
            </tr>
        </table>

        <br>

        {{-- NOTE --}}
        <h4>Note</h4>
        <table class="table-bordered">
            <tr>
                <td style="height:60px;">
                    {{ $job->note }}
                </td>
            </tr>
        </table>

        <br><br>

        {{-- SIGNATURES --}}
        <table class="table-bordered">
            <tr>
                <td style="text-align:center;">
                    Prepared By<br><br>______________
                </td>

                <td style="text-align:center;">
                    Manager<br><br>______________
                </td>

                <td style="text-align:center;">
                    Approved By<br><br>______________
                </td>
            </tr>
        </table>

    </div>
</div>

@endsection