@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Header (Screen Only) -->
    <div class="row no-print">
        <div class="col-12">
            <div class="page-title-box d-flex justify-content-between align-items-center my-3">
                <h4 class="page-title mb-0">Product Details</h4>
                <div>
                    <a href="{{ route('registration_form.reports') }}" class="btn btn-secondary me-1">Back</a>
                    <a href="{{ route('registration_form.edit', $product?->id) }}" class="btn btn-primary me-1">Edit</a>
                    <button type="button" class="btn btn-info me-1" onclick="window.print();">
                        <i class="fa fa-print"></i> Print
                    </button>
                    <!-- ✅ FIXED: Single clean JPG button -->
                    <button class="btn btn-success" onclick="downloadJpg({{ $product->id }})">
                        <i class="fa fa-download"></i> JPG Download
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm" id="printable-area">
                <div class="card-body p-4">

                    <!-- ✅ NEW: Print/PDF Header (ALWAYS visible in PDF/JPG) -->
                    <div class="print-header">
                        <h2>Product Registration Certificate</h2>
                        <small>Generated on: {{ now()->format('d M Y - H:i') }}</small>
                    </div>

                    <!-- Top Section: Details Left, Image Right -->
                    <div class="row">
                        <!-- Left Column: Basic Details -->
                        <div class="col-8 detail-column">
                            <h5 class="text-primary text-uppercase mb-1 section-title">Details</h5>
                            
                            <table class="table table-borderless table-sm detail-table">
                                <tbody>
                                    <tr><th width="35%">Product Name</th><td class="fw-bold fs-5">{{ $product->prod_name ?? 'N/A' }}</td></tr>
                                    <tr><th>Party (Account)</th><td>{{ $product->account->title ?? 'N/A' }}</td></tr>
                                    <tr><th>Product Type</th><td>{{ $product->product_type ?? 'N/A' }}</td></tr>
                                    <tr><th>Job Assigning</th><td>{{ $product->job_assign ?? 'N/A' }}</td></tr>
                                    <tr><th>Item Type</th><td>{{ $product->items->item_code ?? 'N/A' }}</td></tr>
                                    <tr><th>Dimensions (H x W)</th><td>{{ $product->length ?? '-' }} x {{ $product->width ?? '-' }}</td></tr>
                                    <tr><th>Grammage</th><td>{{ $product->grammage ?? 'N/A' }}</td></tr>
                                    <tr><th>Grain / Hard Side</th><td>{{ $product->grain_hard_side ?? 'N/A' }}</td></tr>
                                    <tr><th>Ups</th><td>{{ $product->ups ?? 'N/A' }}</td></tr>
                                    <tr><th>Country</th><td>{{ $product->country->country_name ?? 'N/A' }}</td></tr>
                                    <tr><th>Product Rate</th><td>{{ $product->rate ?? '-' }}</td></tr>
                                    <tr><th>Auto Pasting Rate (CTN)</th><td>{{ $product->auto_pasting_rate ?? '-' }}</td></tr>
                                    <tr><th>Manual Pasting Rate (CTN)</th><td>{{ $product->manual_pasting_rate ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Right Column: Image -->
                        <div class="col-4 image-column text-center">
                            <h5 class="text-primary text-uppercase mb-3 section-title">Product Image</h5>
                            <div class="img-wrapper border rounded p-2">
                                @if($product->file_path)
                                    <img src="{{ asset('storage/' . $product->file_path) }}" alt="Product Image" class="img-fluid rounded">
                                @else
                                    <div class="text-muted py-5 no-image-placeholder">
                                        <i class="fa fa-image fa-3x mb-2"></i><br>No Image Available
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Manufacturing Options -->
                    <h5 class="text-primary text-uppercase mb-3 section-title">Manufacturing Option</h5>
                    <table class="table table-borderless table-sm detail-table">
                        <tbody>
                            @if($product->lamination)
                            <tr><th>Lamination</th><td>Type: {{ $product->lamItem->item_code ?? 'N/A' }}, Size: {{ $product->lam_size ?? 'N/A' }}, Impressions: {{ $product->limpression ?? 'N/A' }}</td></tr>
                            @endif
                            @if($product->uv)
                            <tr><th>UV Coating</th><td>
                                @if($product->simple) Simple (Rate: {{ $product->simple_rate }}) @endif
                                @if($product->spot) Spot (Rate: {{ $product->spot_rate }}) @endif
                                @if($product->tripof) Trip Of (Rate: {{ $product->tripof_rate }}) @endif
                            </td></tr>
                            @endif
                            @if($product->corrugation)
                            <tr><th>Corrugation</th><td>Size: {{ $product->curr_size ?? 'N/A' }}, Type: {{ $product->currItem->item_code ?? 'N/A' }}, Labour: {{ $product->clabour ?? 'N/A' }}</td></tr>
                            @endif
                            @if($product->color)
                            <tr><th>Color Printing</th><td>No. of Colors: {{ $product->color_no }}, Design Colors: {{ $product->design_color }}</td></tr>
                            @endif
                            @if($product->window)
                            <tr><th>Window</th><td>
                                @if($product->glass_win) Glass (Rate: {{ $product->Glass_w_rate }}) @endif
                                @if($product->lam_win) Lam (Rate: {{ $product->Lam_w_rate }}) @endif
                            </td></tr>
                            @endif
                            @if($product->varnish || $product->breaking || $product->emboss)
                            <tr><th>Finishing:</th><td>
                                @if($product->varnish) Varnish: Yes @endif
                                @if($product->breaking) | Breaking Rate: {{ $product->breaking_rate }} @endif
                                @if($product->emboss) | Emboss Rate: {{ $product->emboss_rate }} @endif
                            </td></tr>
                            @endif
                            @if(!$product->lamination && !$product->uv && !$product->corrugation && !$product->color && !$product->window && !$product->varnish && !$product->breaking && !$product->emboss)
                            <tr><td colspan="2" class="text-muted fst-italic">No additional manufacturing options selected.</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Description -->
                    @if($product->descr)
                    <table class="table table-borderless table-sm detail-table mt-4">
                        <tr><th>Description:</th><td>{{ $product->descr }}</td></tr>
                    </table>
                    @endif

                    <!-- ✅ NEW: Print/PDF Footer (ALWAYS visible in PDF/JPG) -->
                    <div class="print-footer">
                        <div class="row">
                            <div class="col-6">
                                <small>Page 1 of 1 | Product ID: {{ $product->id }}</small>
                            </div>
                            <div class="col-6 text-end">
                                <small>Authorized Signature: ___________________</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ NEW COMPLETE STYLE SECTION (REPLACE YOUR OLD ONE) -->
<style>
    /* ========================================
       UNIFIED STYLES FOR SCREEN + PDF + JPG
       ======================================== */
    
    .no-print { display: none !important; }
    
    .print-header { 
        display: block !important; 
        margin: 0 0 30px 0 !important;
        text-align: center !important;
        text-transform: uppercase !important;
        border-bottom: 3px solid #333 !important;
        padding-bottom: 15px !important;
        font-weight: bold !important;
    }
    
    .print-footer { 
        display: block !important; 
        margin-top: 30px !important;
        padding-top: 15px !important;
        border-top: 2px solid #ccc !important;
        font-size: 11px !important;
        color: #666 !important;
    }

    /* BASE STYLES - Screen + Print + PDF */
    @media print, screen and (min-width: 768px) {
        body { 
            font-family: 'Arial', 'Helvetica', sans-serif !important; 
            font-size: 12pt !important; 
            line-height: 1.4 !important;
            color: #000 !important;
            background: #fff !important;
        }
        
        .container-fluid, .row, .col-12, .card, .card-body {
            background: #fff !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
        
        .section-title { 
            font-size: 15pt !important; 
            color: #000 !important; 
            margin: 25px 0 12px 0 !important;
            border-bottom: 2px solid #333 !important;
            padding-bottom: 8px !important;
            text-transform: uppercase !important;
            font-weight: bold !important;
        }
        
        .detail-table {
            width: 100% !important;
            margin-bottom: 18px !important;
        }
        .detail-table th {
            width: 35% !important;
            font-weight: 600 !important;
            color: #333 !important;
            padding: 8px 12px 8px 0 !important;
            vertical-align: top !important;
        }
        .detail-table td {
            color: #000 !important;
            padding: 8px 12px 8px 0 !important;
            font-weight: 500 !important;
        }
        
        .detail-column { width: 65% !important; float: left !important; padding-right: 25px !important; }
        .image-column { width: 35% !important; float: right !important; text-align: center !important; }
        
        .img-wrapper {
            border: 2px solid #ddd !important;
            padding: 15px !important;
            background: #fff !important;
            border-radius: 8px !important;
            max-height: 320px !important;
        }
        .img-fluid {
            max-height: 280px !important;
            max-width: 100% !important;
        }
        
        hr { border: none !important; border-top: 2px solid #ddd !important; margin: 30px 0 !important; }
    }

    /* Screen Only */
    @media screen {
        .card { box-shadow: 0 4px 20px rgba(0,0,0,0.12) !important; border-radius: 12px; }
        .card-body { padding: 30px !important; }
        .print-header, .print-footer { display: none !important; }
        .btn { transition: all 0.2s; }
        .btn:hover { transform: translateY(-1px); }
    }

    @media print {
        * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
        body { font-size: 12pt !important; margin: 0 !important; padding: 25px !important; }
    }
</style>

@endsection

@section('scripts')
<script>
function downloadJpg(productId) {
    window.location.href = `/product/${productId}/jpg`;
}

function openImageView() {
    // Client-side fallback
    html2canvas(document.getElementById('printable-area'), {
        scale: 2,
        useCORS: true,
        width: 794,
        height: 1123
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = `product_${productId}.jpg`;
        link.href = canvas.toDataURL('image/jpeg', 0.95);
        link.click();
    }).catch(() => {
        downloadJpg(productId); // Server fallback
    });
}
</script>
@endsection