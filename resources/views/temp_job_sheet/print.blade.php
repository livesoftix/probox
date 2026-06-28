@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

body{
    font-family:'Poppins',sans-serif;
    background:#f5f7fa;
    color:#333;
}

/* =========================
   MAIN SHEET
========================= */
.a4-sheet{
    width:210mm;
    min-height:297mm;
    margin:auto;
    background:#fff;
    padding:5mm;
    box-sizing:border-box;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

/* =========================
   PAGE TITLE
========================= */
.page-title{
    text-align:center;
    font-size:34px;
    font-weight:700;
    color:#4f6478;
    margin-bottom:20px;
}

/* =========================
   SECTION TITLES
========================= */
.section-title{
    font-size:24px;
    font-weight:600;
    color:#4f6478;
    margin:25px 0 12px;
}

/* =========================
   TABLES
========================= */
.table-bordered{
    width:100%;
    border-collapse:collapse;
}

/* First Info Table + Process Table */
.table-bordered th{
    border:1px solid #000;
    padding:8px;
    background:#fff !important;
    color:#000 !important;
    font-weight:700;
    text-align:left;
}

.table-bordered td{
    border:1px solid #000;
    padding:8px;
    background:#fff !important;
    color:#000 !important;
}

.table-bordered tr{
    background:#fff !important;
}

/* =========================
   BOXBOARD TABLE
========================= */
.boxboard_row th{
    background:#4f6478 !important;
    color:#fff !important;
    text-align:center;
    border:1px solid #000;
    padding:10px;
}

/* =========================
   NOTE BOX
========================= */
.note-box{
    border:1px solid #d8d8d8;
    min-height:50px;
    padding:5px;
    border-radius:6px;
    background:#fff;
}

.note-label{
    font-weight:600;
    margin-bottom:8px;
}

/* =========================
   URDU SECTION
========================= */
.urdu-section{
    direction:rtl;
    font-family:"Jameel Noori Nastaleeq","Noto Nastaliq Urdu",serif;
    margin-top:40px;
}

.urdu-title{
    text-align:center;
    font-size:30px;
    font-weight:bold;
    color:#4f6478;
    margin:25px 0 12px;
}

.urdu-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:25px;
    direction:rtl;
}

.urdu-table th{
    background:#4f6478 !important;
    color:#fff !important;
    text-align:center;
    border:1px solid #000;
    padding:10px;
    font-weight:bold;
}

.urdu-table td{
    border:1px solid #000;
    height:50px;
    padding:8px;
    background:#fff !important;
}

/* =========================
   BUTTONS
========================= */
.no-print{
    margin-bottom:15px;
}

/* =========================
   PRINT SETTINGS
========================= */
@media print{

    .no-print{
        display:none !important;
    }

    body{
        background:#fff !important;
        margin:0;
        padding:0;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .container-fluid{
        padding:0 !important;
        margin:0 !important;
    }

    .a4-sheet{
        width:100%;
        box-shadow:none !important;
        border:none !important;
        border-radius:0 !important;
        padding:8mm;
        margin:0;
    }

    /* FIRST TABLE + PROCESS TABLE */
    .table-bordered th{
        background:#fff !important;
        color:#000 !important;
        border:1px solid #000 !important;
    }

    .table-bordered td{
        background:#fff !important;
        color:#000 !important;
        border:1px solid #000 !important;
    }

    /* BOXBOARD HEADER */
    .boxboard_row th{
        background:#4f6478 !important;
        color:#fff !important;
        border:1px solid #000 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* URDU TABLE HEADERS */
    .urdu-table th{
        background:#4f6478 !important;
        color:#fff !important;
        border:1px solid #000 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .urdu-table td{
        border:1px solid #000 !important;
    }

    .urdu-title{
        color:#4f6478 !important;
        font-weight:bold !important;
    }

    table{
        page-break-inside:auto;
    }

    tr{
        page-break-inside:avoid;
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

       <h1 class="page-title">JOB SHEET</h1>

        {{-- BASIC INFO --}}
       <table class="table-bordered">
    <tr>
        <th>Date</th>
        <td>{{ $job->date }}</td>

        <th>Job No</th>
        <td>TJS-{{ $job->v_no }}</td>

       
    </tr>

   

    <tr>
         <th>Prepared By</th>
        <td>{{ $job->preparedby }}</td>
        <th>Printing For</th>
        <td colspan="5">{{ $job->printing_for }}</td>

    </tr>
     <tr>
        <th>Job Name</th>
        <td colspan="5">{{ $job->product?->prod_name }}</td>
    </tr>
<tr>
    <th>Ups</th>
        <td>{{ $job->ups }}</td>

        <th>Qty of Boxes</th>
        <td colspan="3">{{ $job->qty }}</td>
</tr>
    <tr>
        <th>Size</th>
        <td>{{ $job->size }}</td>

        <th>P.Size</th>
        <td colspan="3">{{ $job->p_size }}</td>
    </tr>

    <tr>
        <th>M Date</th>
        <td>{{ $job->m_date }}</td>

        <th>E Date</th>
        <td colspan="3">{{ $job->e_date }}</td>
    </tr>
</table>

        <br>

        {{-- BOXBOARD --}}
       <h3 class="section-title">Boxboard</h3>

        <table class="table-bordered">
            <thead>
    <tr class="boxboard_row">
        <th>#</th>
        <th>Item</th>
        <th>Length</th>
        <th>Width</th>
        <th>T.Stock</th>
        <th>Used Qty</th>
        <th>Remaining</th>
    </tr>
</thead>

<tbody>
@forelse($job->boxboards as $key => $box)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $box->item->item_code ?? '' }}</td>
        <td>{{ $box->length }}</td>
        <td>{{ $box->width }}</td>

        {{-- FROM VIEW --}}
        <td>{{ $box->remain_stock+$box->qty ?? 0 }}</td>

        <td>{{ $box->qty }}</td>

        <td>{{ $box->remain_stock?? 0 }}</td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No Boxboard Found</td>
    </tr>
@endforelse
</tbody>
        </table>

        <br>

        {{-- PROCESS --}}
        <h3 class="section-title">Process</h3>

<table class="table-bordered">

    <tr>
        <th>Lamination</th>
        <td>{{ $job->lamination ? 'Yes' : 'No' }}</td>

        <th>Lamination Size</th>
        <td>{{ $job->lam_size }}</td>
    </tr>

    <tr>
        <th>Lamination Item</th>
        <td>{{ $job->lamItem->item_code ?? '' }}</td>

        <th>Corrugation</th>
        <td>{{ $job->currItem ? 'Yes' : 'No' }}</td>
    </tr>

    <tr>
        <th>Corrugation Size</th>
        <td>{{ $job->curr_size }}</td>

        <th>Corrugation Item</th>
        <td>{{ $job->corrugationItem->item_code ?? '' }}</td>
    </tr>

    <tr>
        <th>Design Color</th>
        <td>{{ $job->color ? 'Yes' : 'No' }}</td>

        <th>No. of Colors</th>
        <td>{{ $job->color_no }}</td>
    </tr>

    <tr>
        <th>Window</th>
        <td>{{ $job->window ? 'Yes' : 'No' }}</td>

        <th>Glass Window</th>
        <td>{{ $job->glass_win ? 'Yes' : 'No' }}</td>
        
    </tr>

    <tr>
         <th>Lamination Window</th>
        <td>{{ $job->lam_window ? 'Yes' : 'No' }}</td>
        <th>UV</th>
        <td>{{ $job->uv ? 'Yes' : 'No' }}</td>

       
    </tr>

    <tr>
         <th>Simple</th>
        <td>{{ $job->simple ? 'Yes' : 'No' }}</td>
        <th>Spot UV</th>
        <td>{{ $job->spot ? 'Yes' : 'No' }}</td>

        
    </tr>

    <tr>
        <th>Varnish</th>
        <td>{{ $job->varnish ? 'Yes' : 'No' }}</td>

        <th>Emboss</th>
        <td>{{ $job->emboss ? 'Yes' : 'No' }}</td>

    </tr>

    <tr>
        <!-- <th>Emboss Rate</th>
        <td>{{ $job->emboss_rate }}</td> -->
<th>Trip Of</th>
        <td>{{ $job->tripof ? 'Yes' : 'No' }}</td>
        <th>Breaking</th>
        <td>{{ $job->breaking ? 'Yes' : 'No' }}</td>
    </tr>

</table>
        {{-- NOTE --}}
        <h3 class="section-title">Notes</h3>
        <div class="note-box">
    {{ $job->note }}
</div>
        <table class="table-bordered">
          
   <div class="urdu-section">

    <h2 class="urdu-title">جاب پرنٹنگ سیکشن</h2>

    <table class="table-bordered urdu-table">
        <tr>
            <th>مشین نام</th>
            <th>مشین مین</th>
            <th>کل تعداد</th>
            <th>منظور شدہ</th>
            <th>ردی</th>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <h2 class="urdu-title" style="margin-top:25px;">
        یووی کوٹنگ / لیمینیشن سیکشن
    </h2>

    <table class="table-bordered urdu-table">
        <tr>
            <th>مشین مین</th>
            <th>کل تعداد</th>
            <th>منظور شدہ</th>
            <th>ردی</th>
            <th>ردی بوجہ لیمینیشن</th>
            <th>ان کوٹڈ</th>
            <th>خراب پرنٹنگ</th>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <h2 class="urdu-title" style="margin-top:25px;">
        ڈبل پیسٹنگ / ڈائی کٹنگ سیکشن
    </h2>

    <table class="table-bordered urdu-table">
        <tr>
            <th>مشین مین</th>
            <th>کل تعداد</th>
            <th>منظور شدہ</th>
            <th>ردی</th>
            <th>ردی بوجہ لیمینیشن</th>
            <th>ان کوٹڈ</th>
            <th>خراب پرنٹنگ</th>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

</div>

        {{-- SIGNATURES --}}
        <!-- <table class="table-bordered">
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
        </table> -->

    </div>
</div>

@endsection