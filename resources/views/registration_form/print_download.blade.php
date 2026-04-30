@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- ❌ This will NOT be captured -->
    <div class="no-print row">
        <div class="col-12">
            <div class="d-flex justify-content-between my-3">
                <h4>Product Details</h4>

                <div>
                    <!-- <button class="btn btn-info" onclick="window.print()">Print</button>

                    <button class="btn btn-success" onclick="downloadJpg({{ $product->id }})">
                        JPG Download
                    </button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ ONLY THIS WILL BE CAPTURED -->
    <div id="printable-area">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h3 class="text-center border-bottom pb-2 mb-4">
                    Product Registration Certificate
                </h3>

                <div class="row">

                    <!-- LEFT -->
                    <div class="col-8">

                        <h5>Details</h5>

                        <table class="table table-borderless table-sm">
                            <tr>
                                <th>Product Name</th>
                                <td>{{ $product->prod_name }}</td>
                            </tr>
                            <tr>
                                <th>Account</th>
                                <td>{{ $product->account->title ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $product->product_type }}</td>
                            </tr>
                            <tr>
                                <th>Job</th>
                                <td>{{ $product->job_assign }}</td>
                            </tr>
                            <tr>
                                <th>Item</th>
                                <td>{{ $product->items->item_code ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Size</th>
                                <td>{{ $product->length }} x {{ $product->width }}</td>
                            </tr>
                            <tr>
                                <th>Grammage</th>
                                <td>{{ $product->grammage }}</td>
                            </tr>
                        </table>

                    </div>

                    <!-- RIGHT IMAGE (FIXED CORS + PATH) -->
                    <div class="col-4 text-center">

                        <h5>Image</h5>

                        <div class="border p-2">

                            @php
                                $imageUrl = $product->file_path
                                    ? 'https://real-erp.net/probox/storage/' . $product->file_path
                                    : null;

                                $base64 = null;

                                if ($imageUrl) {
                                    try {
                                        $data = @file_get_contents($imageUrl);
                                        if ($data) {
                                            $base64 = 'data:image/jpeg;base64,' . base64_encode($data);
                                        }
                                    } catch (\Exception $e) {
                                        $base64 = null;
                                    }
                                }
                            @endphp

                            @if($base64)
                                <img src="{{ $base64 }}"
                                     style="max-width:100%; max-height:280px;">
                            @else
                                <img src="https://via.placeholder.com/300x250?text=No+Image">
                            @endif

                        </div>

                    </div>

                </div>

                <hr>

                <h5>Manufacturing Options</h5>

                <table class="table table-borderless table-sm">
                    @if($product->lamination)
                    <tr>
                        <th>Lamination</th>
                        <td>{{ $product->lamItem->item_code ?? '' }}</td>
                    </tr>
                    @endif

                    @if($product->uv)
                    <tr>
                        <th>UV</th>
                        <td>Yes</td>
                    </tr>
                    @endif
                </table>

                @if($product->descr)
                <hr>
                <h5>Description</h5>
                <p>{{ $product->descr }}</p>
                @endif

            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
window.onload = function () {

    const element = document.getElementById('printable-area');

    // wait a bit for images to fully render
    setTimeout(() => {

        html2canvas(element, {
            scale: 3,
            useCORS: true,
            allowTaint: true,
            backgroundColor: "#fff"
        }).then(canvas => {

            const imgData = canvas.toDataURL("image/jpeg", 1.0);

            const link = document.createElement('a');
            link.href = imgData;
            link.download = "product_{{ $product->id }}.jpg";

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

        });

    }, 800); // IMPORTANT delay for image load

};
</script>
@endsection