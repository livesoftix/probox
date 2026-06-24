@extends('layouts.app')

@section('content')
<style>
.urdu-section{
    direction: rtl;
    font-family: "Jameel Noori Nastaleeq","Noto Nastaliq Urdu",serif;
    font-size: 20px;
    margin-top: 20px;
}

.urdu-title{
    font-weight: bold;
    font-size: 26px;
    text-align: center;
    margin: 15px 0;
}

.urdu-row{
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 8px 0;
}

.urdu-line{
    flex: 1;
    border-bottom: 1px solid #000;
    height: 25px;
}

.note-box{
    border:1px solid #000;
    height:180px;
    margin-top:10px;
    position:relative;
}

.note-box .line{
    border-bottom:1px solid #ccc;
    height:35px;
}

.note-label{
    font-weight:bold;
    margin-bottom:5px;
}

.a4-sheet{
    width:210mm;
    min-height:297mm;
    margin:auto;
    background:#fff;
    padding:10mm;
    box-sizing:border-box;
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

        <h3 class="text-center mb-3">JOB SHEET</h3>

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
        <h4>Boxboard</h4>

        <table class="table-bordered">
            <thead>
    <tr>
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
        <td>{{ $box->t_stock ?? 0 }}</td>

        <td>{{ $box->qty }}</td>

        <td>{{ $box->t_stock-$box->qty ?? 0 }}</td>
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
        <h4>Process</h4>

        <table class="table-bordered">
            <tr>
                <th>Lamination</th>
                <td>{{ $job->lamination }}</td>

                <th>Embossing</th>
                <td>{{ $job->embossing  }}</td>
            </tr>

            <tr>
                <th>Varnish</th>
                <td>{{ $job->varnish  }}</td>

                <th>Colour</th>
                <td>{{ $job->colour }}</td>
            </tr>

            <tr>
                <th>UV</th>
                <td>{{ $job->uv  }}</td>

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
<hr style="margin:30px 0;">

<div class="urdu-section">

    <div class="urdu-title">
         جاب پرنٹنگ سیکشن
    </div>

    <div class="urdu-row">
        <span>مشین نام</span>
        <div class="urdu-line"></div>
    </div>

    <div class="urdu-row">
        <span>مشین مین</span>
        <div class="urdu-line"></div>
</div>
<div class="urdu-row">
    <span>کلر نام</span>
        <div class="urdu-line"></div>

        <span>تعداد</span>
        <div class="urdu-line"></div>

        <span>منظور شدہ</span>
        <div class="urdu-line"></div>

        <span>ردی</span>
        <div class="urdu-line"></div>

        
    </div>

  


    <div class="urdu-title">
        یووی کوٹنگ / لیمینیشن سیکشن
    </div>

    <div class="urdu-row">
         <span>مشین مین</span>
        <div class="urdu-line"></div>

        
    </div>
    <div class="urdu-row">
         <span>کل تعداد</span>
        <div class="urdu-line"></div>

        <span>منظور شدہ</span>
        <div class="urdu-line"></div>

        <span>ردی</span>
        <div class="urdu-line"></div>
</div>

    <div class="urdu-row">
        <span>ردی بوجہ لیمینیشن</span>
        <div class="urdu-line"></div>

        <span>ان کوٹڈ</span>
        <div class="urdu-line"></div>

        <span>خراب پرنٹنگ</span>
        <div class="urdu-line"></div>
    </div>


    <div class="urdu-title">
        ڈبل پیسٹنگ / ڈائی کٹنگ سیکشن
    </div>

     <div class="urdu-row">
         <span>مشین مین</span>
        <div class="urdu-line"></div>

        
    </div>
    <div class="urdu-row">
        <span>کل تعداد</span>
        <div class="urdu-line"></div>

        <span>منظور شدہ</span>
        <div class="urdu-line"></div>

        <span>ردی</span>
        <div class="urdu-line"></div>
</div>
    <div class="urdu-row">
         <span>ردی بوجہ لیمینیشن</span>
        <div class="urdu-line"></div>

        <span>ان کوٹڈ</span>
        <div class="urdu-line"></div>

        <span>خراب پرنٹنگ</span>
        <div class="urdu-line"></div>
    </div>

    <br>

    <div class="note-label">نوٹ</div>

    <div class="note-box">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

</div>
        <br><br>

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