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
                    <a href="{{ route('registration_form.edit', $product->id) }}" class="btn btn-primary me-1">Edit</a>
                    <button type="button" class="btn btn-info" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm" id="printable-area">
                <div class="card-body p-4">

                    <!-- Print Only Header -->
                    <div class="print-header mb-4" style="display:none;">
                        <h2 class="text-center text-uppercase border-bottom pb-2">Product Registration Print</h2>
                    </div>

                    <!-- Top Section: Details Left, Image Right -->
                    <div class="row">
                        <!-- Left Column: Basic Details -->
                        <div class="col-8 detail-column">
                            <h5 class="text-primary text-uppercase mb-1 section-title">Details</h5>
                            
                            <table class="table table-borderless table-sm detail-table">
                                <tbody>
                                    <tr>
                                        <th width="35%">Product Name</th>
                                        <td class="fw-bold fs-5">{{ $product->prod_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Party (Account)</th>
                                        <td>{{ $product->account->title ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Type</th>
                                        <td>{{ $product->product_type ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Job Assigning</th>
                                        <td>{{ $product->job_assign ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Item Type</th>
                                        <td>{{ $product->items->item_code ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensions (H x W)</th>
                                        <td>{{ $product->length ?? '-' }} x {{ $product->width ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Grammage</th>
                                        <td>{{ $product->grammage ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Grain / Hard Side</th>
                                        <td>{{ $product->grain_hard_side ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ups</th>
                                        <td>{{ $product->ups ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td>{{ $product->country->country_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Rate</th>
                                        <td>{{ $product->rate ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Auto Pasting Rate (CTN)</th>
                                        <td>{{ $product->auto_pasting_rate ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Manual Pasting Rate (CTN)</th>
                                        <td>{{ $product->manual_pasting_rate ?? '-' }}</td>
                                    </tr>
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
                                    <div class="text-muted py-5">
                                        <i class="fa fa-image fa-3x mb-2"></i><br>
                                        No Image Available
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Middle Section: Additional Options Grid -->

                        <h5 class="text-primary text-uppercase mb-3 section-title">Manufacturing Option</h5>
                        <table class="table table-borderless table-sm detail-table">
                            <tbody>
                                @if($product->lamination)
                                <tr>
                                    <th>Lamination</th>
                                    <td>
                                        Type: {{ $product->lamItem->item_code ?? 'N/A' }},
                                        Size: {{ $product->lam_size ?? 'N/A' }},
                                        Impressions: {{ $product->limpression ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endif
                                @if($product->uv)
                                <tr>
                                    <th>UV Coating</th>
                                    <td>
                                        @if($product->simple) Simple (Rate: {{ $product->simple_rate }}) @endif
                                        @if($product->spot) Spot (Rate: {{ $product->spot_rate }}) @endif
                                        @if($product->tripof) Trip Of (Rate: {{ $product->tripof_rate }}) @endif
                                    </td>
                                </tr>
                                @endif
                                @if($product->corrugation)
                                <tr>
                                    <th>Corrugation</th>
                                    <td>
                                        Size: {{ $product->curr_size ?? 'N/A' }},
                                        Type: {{ $product->currItem->item_code ?? 'N/A' }},
                                        Labour: {{ $product->clabour ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endif
                                @if($product->color)
                                <tr>
                                    <th>Color Printing</th>
                                    <td>
                                        No. of Colors: {{ $product->color_no }},
                                        Design Colors: {{ $product->design_color }}
                                    </td>
                                </tr>
                                @endif
                                @if($product->window)
                                <tr>
                                    <th>Window</th>
                                    <td>
                                        @if($product->glass_win) Glass (Rate: {{ $product->Glass_w_rate }}) @endif
                                        @if($product->lam_win) Lam (Rate: {{ $product->Lam_w_rate }}) @endif
                                    </td>
                                </tr>
                                @endif
                                @if($product->varnish || $product->breaking || $product->emboss)
                                <tr>
                                    <th>Finishing:</th>
                                    <td>
                                        @if($product->varnish) Varnish: Yes. @endif
                                        @if($product->breaking) Breaking Rate: {{ $product->breaking_rate }}. @endif
                                        @if($product->emboss) Embosse Rate: {{ $product->emboss_rate }}. @endif
                                    </td>
                                </tr>
                                @endif
                                @if(!$product->lamination && !$product->uv && !$product->corrugation && !$product->color && !$product->window && !$product->varnish && !$product->breaking && !$product->emboss)
                                <tr>
                                    <td colspan="2" class="text-muted fst-italic">No additional manufacturing options selected.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>


                    <!-- Bottom Section: Description as simple detail -->
                    @if($product->descr)
                    <table class="table table-borderless table-sm detail-table mt-4">
                        <tbody>
                            <tr>
                                <th class="w-auto">Description:</th>

                                <td>{{ $product->descr }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif

                    <!-- Print Footer -->
                    <div class="print-footer border-top mt-4" style="display:none;">
                        <div class="row">
                            <div class="col-6 text-start"><small>Printed on: {{ now()->format('d-M-Y') }}</small></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Clean Table Styling */
    .detail-table th {
        color: #555;
        font-weight: 600;
        padding-bottom: 8px;
    }
    .detail-table td {
        color: #000;
        padding-bottom: 8px;
    }
    
    /* Image Wrapper */
    .img-wrapper {
        background: #fff;
        display: inline-block;
    }

    /* Print Specific Styling */
    @media print {
        /* Hide UI Elements */
        .no-print, nav, header, footer, .btn {
            display: none !important;
        }

        /* Reset Layout for Paper */
        body, html, .container-fluid, .card, .card-body {
            background-color: #fff !important;
            width: 100%;
            margin: 0;
            padding: 0;
            border: none !important;
            box-shadow: none !important;
        }

        /* Force Header Display */
        .print-header { display: block !important; }
        .print-footer { display: block !important; }
        /* Reduce margin/padding for description and footer in print */
        .detail-table, .detail-table th, .detail-table td {
            margin-bottom: 0 !important;
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }
        .print-footer {
            margin-top: 4px !important;
            padding-top: 2px !important;
        }

        /* Force Grid Layout in Print (Bootstrap usually handles this, but we force it to be safe) */
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        
        /* Layout specific: Left Column 66%, Right Column 33% */
        .detail-column {
            width: 65% !important;
            flex: 0 0 65%;
        }
        .image-column {
            width: 35% !important;
            flex: 0 0 35%;
        }

        /* Option Boxes - 3 per row on print */
        .item-box {
            width: 33% !important;
            flex: 0 0 33%;
            margin-bottom: 15px;
        }

        /* Visual Tweaks */
        .pricing-box {
            border: 1px solid #ffffffff !important;
            background-color: #f9f9f9 !important; /* Force background color print setting dependent */
            -webkit-print-color-adjust: exact;
        }

        /* Ensure Image Size */
        .img-fluid {
            max-height: 300px;
            width: auto;
        }
        
        /* Font Sizing for Print */
        body { font-size: 12pt; }
        h5 { font-size: 14pt; color: #000 !important; margin-top: 10px; border-bottom: 1px solid #ccc; }
        .text-primary { color: #000 !important; }
    }
</style>

@endsection