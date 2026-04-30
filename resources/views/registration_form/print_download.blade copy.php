<!DOCTYPE html>
<html>
<head>
    <title>Product JPG Download</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        body{
            margin:0;
            background:#fff;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* A4 SIZE FIX */
        #printable-area{
            width: 794px;
            margin: auto;
            padding: 25px;
            background: #fff;
        }

        .card-box{
            border:1px solid #ddd;
            padding:20px;
        }

        .row{
            display:flex;
        }

        .col-left{
            width:65%;
            padding-right:15px;
        }

        .col-right{
            width:35%;
            text-align:center;
        }

        h2{
            text-align:center;
            border-bottom:2px solid #000;
            padding-bottom:10px;
            margin-bottom:20px;
            font-size:18px;
            text-transform:uppercase;
        }

        .section-title{
            font-size:14px;
            font-weight:bold;
            text-transform:uppercase;
            border-bottom:1px solid #000;
            margin:15px 0 10px;
            padding-bottom:5px;
        }

        table{
            width:100%;
            font-size:12px;
            border-collapse:collapse;
        }

        th{
            text-align:left;
            width:40%;
            padding:4px 0;
            color:#555;
            vertical-align:top;
        }

        td{
            padding:4px 0;
        }

        .img-box{
            border:1px solid #ccc;
            padding:10px;
        }

        img{
            max-width:100%;
            max-height:280px;
        }

        hr{
            margin:20px 0;
        }
    </style>
</head>

<body>

<div id="printable-area">

    <h2>Product Registration Certificate</h2>

    <div class="card-box">

        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-left">

                <div class="section-title">Details</div>

                <table>
                    <tr><th>Product Name</th><td>{{ $product->prod_name ?? 'N/A' }}</td></tr>
                    <tr><th>Account</th><td>{{ $product->account->title ?? 'N/A' }}</td></tr>
                    <tr><th>Type</th><td>{{ $product->product_type ?? 'N/A' }}</td></tr>
                    <tr><th>Job</th><td>{{ $product->job_assign ?? 'N/A' }}</td></tr>
                    <tr><th>Item</th><td>{{ $product->items->item_code ?? 'N/A' }}</td></tr>
                    <tr><th>Size</th><td>{{ $product->length ?? '' }} x {{ $product->width ?? '' }}</td></tr>
                    <tr><th>Grammage</th><td>{{ $product->grammage ?? 'N/A' }}</td></tr>
                    <tr><th>Country</th><td>{{ $product->country->country_name ?? 'N/A' }}</td></tr>
                </table>

            </div>

            <!-- RIGHT SIDE IMAGE (FIXED BASE64) -->
            <div class="col-right">

                <div class="section-title">Product Image</div>

                <div class="img-box">

                 @php
    $imageUrl = $product->file_path 
        ? 'https://real-erp.net/probox/storage/' . $product->file_path
        : null;

    $base64 = null;

    if ($imageUrl) {
        try {
            $type = pathinfo($imageUrl, PATHINFO_EXTENSION);
            $data = file_get_contents($imageUrl);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } catch (\Exception $e) {
            $base64 = null;
        }
    }
@endphp

@if($base64)
    <img src="{{ $base64 }}">
@else
    <img src="https://via.placeholder.com/300x250?text=No+Image">
@endif

                </div>

            </div>

        </div>

        <hr>

        <div class="section-title">Manufacturing Options</div>

        <table>
            @if($product->lamination)
            <tr>
                <th>Lamination</th>
                <td>{{ $product->lamItem->item_code ?? 'N/A' }}</td>
            </tr>
            @endif

            @if($product->uv)
            <tr>
                <th>UV</th>
                <td>Yes</td>
            </tr>
            @endif

            @if($product->corrugation)
            <tr>
                <th>Corrugation</th>
                <td>{{ $product->currItem->item_code ?? 'N/A' }}</td>
            </tr>
            @endif
        </table>

        @if($product->descr)
        <div class="section-title">Description</div>
        <p style="font-size:12px;">
            {{ $product->descr }}
        </p>
        @endif

    </div>

</div>

<script>
window.onload = function () {

    // wait images fully loaded
    setTimeout(() => {

        html2canvas(document.getElementById('printable-area'), {
            scale: 3,
            useCORS: true,
            backgroundColor: "#fff"
        }).then(canvas => {

            let link = document.createElement('a');
            link.download = "product_{{ $product->id }}.jpg";
            link.href = canvas.toDataURL("image/jpeg", 1.0);
            link.click();

        });

    }, 500);

};
</script>

</body>
</html>