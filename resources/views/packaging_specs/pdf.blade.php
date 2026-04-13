<!DOCTYPE html>
<html>

<head>
    <style>
        /* General Styles - Kept largely the same */
        .spec-value {
            border-bottom: 1px solid #666;
            flex: 1;
            margin-left: 4px;
            padding: 1px 2px 0 2px;
            min-width: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.3;
            /* Adjust font size for better A5 fit if necessary, but 15px is okay */
        }

        .spec-value.size-small {
            min-width: 30px;
            max-width: 50px;
            font-size: 0.95em;
            padding-left: 1px;
            padding-right: 1px;
        }

        .spec-value.bold-large {
            font-size: 1.2em;
            /* Slightly smaller for A5 */
            font-weight: bold;
        }

        .spec-label.bold-large {
            font-size: 1.15em;
            /* Slightly smaller for A5 */
            font-weight: bold;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            /* Reduced body font size slightly for A5 fit */
            margin: 0;
            padding: 0;
            color: #222;
            background: #fff;
        }

        /* Screen View Styles */
        .container {
            border: 1.5px solid #000;
            box-sizing: border-box;
            /* Using A5 dimensions in mm (148mm x 210mm) converted to a common print DPI (e.g., 96dpi) is a good starting point, but they are often adjusted for on-screen viewing. */
            width: 148mm;
            height: 210mm;
            max-width: 100vw;
            max-height: 100vh;
            padding: 10px;
            /* Reduced padding for screen view */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin: 20px auto;
            background: #fff;
        }

        /* Print Media Query - CRITICAL CHANGES HERE */
        @media print {

            /* Define the paper size and minimal margins */
            @page {
                size: A5 landscape;
                /* Changed to A5 portrait for a standard packaging spec */
                margin: 0;
                /* Minimal margin to fit content edge-to-edge */
            }

            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            /* Make the container fill the entire printable area */
            .container {
                width: 100%;
                height: 100%;
                min-width: unset;
                min-height: unset;
                max-width: unset;
                max-height: unset;
                box-sizing: border-box;
                border: 1px solid #000;
                /* Use a consistent border for printing */
                margin: 0;
                padding: 0.3cm;
                /* Padding inside the container, matching @page margin */
                /* Adjust font size for printing if needed */
                font-size: 10pt;
            }

            /* Adjust column sizes for A5 */
            .left-col {
                flex: 1.3;
                /* Increased left column size */
            }

            .right-col {
                flex: 0 0 240px;
                /* Increased fixed width for right column to give image more space */
                gap: 12px;
                /* Reduced gap */
            }

            .main-layout {
                gap: 15px;
                /* Reduced gap between columns */
            }

            .specs-grid {
                gap: 8px 10px;
                /* Reduced grid gaps */
            }

            .header-section {
                margin-bottom: 10px;
                padding-bottom: 5px;
            }

            

            .box-details {
                padding: 8px;
                /* Reduced padding */
                font-size: 0.9em;
            }

            .ups-table {
                font-size: 0.85em;
                /* Smaller table text */
            }

            .checkbox-box.checkbox-checked {
                background-color: #000 !important;
                /* Force solid black fill */
                color: #fff !important;
                /* Force white checkmark/content for contrast */
                -webkit-print-color-adjust: exact;
                /* CRITICAL for Chrome/Safari to respect background color */
                print-color-adjust: exact;
                /* Standard for other browsers */
                border-color: #000 !important;
                /* Match the border to the fill */
            }
        }

        /* Remaining Styles - Adjustments for A5 */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 15px;
            padding-bottom: 6px;
        }

        .header-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .spec-label {
            font-weight: bold;
            min-width: 90px;
            /* Reduced min-width */
            display: inline-block;
        }

        .unit {
            margin-left: 2px;
            color: #444;
            font-size: 0.85em;
        }

        .main-layout {
            display: flex;
            gap: 15px;
            /* Reduced gap for a tighter fit */
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .left-col {
            flex: 1.3;
            /* Slightly increased left column flex */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .right-col {
            flex: 0 0 340px;
            /* Much wider right column for bigger image */
            display: flex;
            flex-direction: column;
            gap: 12px;
            height: 100%;
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 10px;
            /* Reduced gaps */
            margin-bottom: 15px;
        }

        .spec-row {
            display: flex;
            align-items: baseline;
        }

        .box-type-row {
            display: flex;
            align-items: baseline;
            margin-bottom: 4px;
        }

        .box-details {
            padding: 10px;
            font-size: 0.9em;
        }

        .box-details-title {
            font-weight: bold;
            margin-bottom: 6px;
            text-decoration: underline;
        }

        .box-detail-row {
            display: flex;
            align-items: baseline;
            margin-bottom: 4px;
        }

        .finishing-wrapper {
            display: grid;
            gap: 8px 10px;
            /* Reduced gaps */
            margin-top: 15px;
            padding-top: 10px;
        }

        .finishing-2x2 {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
        }

        .finishing-col {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .col-label {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .finishing-item {
            display: flex;
            align-items: center;
            font-size: 0.85em;
            /* Smaller font for finishing items */
        }

        .checkbox-box {
            width: 14px;
            height: 14px;
            border: 1px solid #222;
            margin-right: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            color: #222;
            background: #fff;
        }

        .checkbox-checked {
            background: #222;
            color: #fff;
        }

        .diagram-section {
    position: relative;
    width: 100%;
    height: 340px;
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #fafafa;
}

        .diagram-img,
.diagram-embed {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
    border: none;
}

.diagram-placeholder {
    font-size: 12px;
    text-align: center;
    color: #555;
    font-style: italic;
}

        .print-options {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            /* Reduced gap */
        }

        .spec-value.size-medium {
            font-size: 13px;
            padding: 1px 4px;
            max-width: 200px;
            word-break: break-word;
        }

        .print-option {
            display: flex;
            align-items: center;
            font-size: 0.85em;
        }

        table.ups-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-top: 4px;
            font-size: 0.88em;
            /* Adjusted table font size */
        }

        .ups-table th,
        .ups-table td {
            padding: 3px;
            border-bottom: 1px solid #aaa;
        }

        .ups-table th {
            font-weight: bold;
            background: #f0f0f0;
        }
    </style>

    <script>
        window.onload = function() {
            setTimeout(function() {
                var hasPdfEmbed = document.querySelector('.diagram-embed');
                if (!hasPdfEmbed) {
                    window.print();
                }
            }, 500);
        };
    </script>
</head>

<body>
    <div class="container">
        <div class="header-section">
            <div class="header-item">
                <span class="spec-label bold-large">Company Name</span>:
                <span class="spec-value bold-large">{{ $packagingSpec->company_name }}</span>
            </div>
            <div class="header-item">
                <span class="spec-label">Date</span>:
                <span class="spec-value">{{ $packagingSpec->date }}</span>
            </div>
        </div>

        <div style="margin-bottom: 12px;">
            <div class="spec-row">
                <span class="spec-label bold-large">Item Name</span>:
                <span class="spec-value bold-large">{{ $packagingSpec->item_name }}</span>
            </div>
        </div>

        <div class="main-layout">
            <div class="left-col">

                <div class="specs-grid">
                    {{-- UPS Detail Table --}}
                    @if ($packagingSpec->details && $packagingSpec->details->count())
                        <div class="spec-row" style="grid-column: 1 / -1;">
                            <span class="spec-label bold-large">Sizes</span>:
                            <span class="spec-value bold-large" style="flex:1; display:block;">
                                <table class="ups-table">
                                    <thead>
                                        <tr>
                                            <th>UPS</th>
                                            <th>Manual Die Size</th>
                                            <th>Auto Die Size</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packagingSpec->details as $i => $d)
                                            <tr>
                                                <td>{{ $d->ups }}</td>
                                                <td>{{ $d->printing_size }}</td>
                                                <td>{{ $d->board_size }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </span>
                        </div>
                    @else
                        <div class="spec-row"><span class="spec-label">Printing Size</span>: <span
                                class="spec-value">{{ $packagingSpec->printing_size ?? '—' }}</span></div>
                        <div class="spec-row"><span class="spec-label">Board Size</span>: <span
                                class="spec-value">{{ $packagingSpec->board_size ?? '—' }}</span></div>
                        <div class="spec-row"><span class="spec-label">UPS</span>: <span
                                class="spec-value">{{ $packagingSpec->ups ?? '—' }}</span></div>
                    @endif

                    <div style="grid-column: 1 / -1; height: 12px;"></div>
                    <div class="spec-row" style="grid-column: 1;">
                        <span class="spec-label">Designing Color</span>: <span
                            class="spec-value">{{ $packagingSpec->designing_color ?? '—' }}</span>
                    </div>
                    <div class="spec-row" style="grid-column: 2;">
                        <span class="spec-label">Printing Side</span>: <span
                            class="spec-value">{{ $packagingSpec->printing_side ?? '—' }}</span>
                    </div>

                    <div class="spec-row" style="grid-column: 1;">
                        <span class="spec-label">Lamination Size</span>: <span
                            class="spec-value">{{ $packagingSpec->lam_size }}</span>
                    </div>
                    <div class="spec-row" style="grid-column: 2;">
                        <span class="spec-label">Length</span>: <span
                            class="spec-value size-small">{{ $packagingSpec->length }}</span> <span
                            class="unit">{{ $packagingSpec->unit }}</span>
                    </div>
                    <div class="spec-row" style="grid-column: 1;">
                        <span class="spec-label">Flute Size</span>: <span
                            class="spec-value">{{ $packagingSpec->flute_size }}</span>
                    </div>
                    <div class="spec-row" style="grid-column: 2;">
                        <span class="spec-label">Width</span>: <span
                            class="spec-value size-small">{{ $packagingSpec->width }}</span> <span
                            class="unit">{{ $packagingSpec->unit }}</span>
                    </div>
                    
                    <div class="spec-row" style="grid-column: 1;">
                        <span class="spec-label">Country</span>: <span
                            class="spec-value">{{ $packagingSpec->country ?? '—' }}</span>
                    </div>
                    <div class="spec-row" style="grid-column: 2;">
                        <span class="spec-label">Height</span>: <span
                            class="spec-value size-small">{{ $packagingSpec->height }}</span> <span
                            class="unit">{{ $packagingSpec->unit }}</span>
                    </div>
                </div>

                <div class="box-type-row">
                    <span class="spec-label">Box Type</span>:
                    <span
                        class="spec-value size-medium">{{ optional($packagingSpec->boxType)->item_code ?? ($packagingSpec->box_type ?? 'N/A') }}</span>
                </div>


                <div class="finishing-wrapper finishing-2x2">
                    <div class="finishing-col" style="grid-row:1;grid-column:1;">
                        <div class="col-label">Finishing:</div>
                        <label class="finishing-item">
                            <span class="checkbox-box{{ $packagingSpec->emboss ? ' checkbox-checked' : '' }}"></span>
                            Emboss
                        </label>
                        <label class="finishing-item">
                            <span class="checkbox-box{{ $packagingSpec->demboss ? ' checkbox-checked' : '' }}"></span>
                            Deboss
                        </label>
                        <label class="finishing-item">
                            <span
                                class="checkbox-box{{ $packagingSpec->gold_finish ? ' checkbox-checked' : '' }}"></span>
                            Gold finish
                        </label>
                        <label class="finishing-item">
                            <span
                                class="checkbox-box{{ $packagingSpec->silver_finish ? ' checkbox-checked' : '' }}"></span>
                            Silver finish
                        </label>
                        
                    </div>
                    <div class="finishing-col" style="grid-row:1;grid-column:2;">
                        <div class="col-label">UV:</div>
                        <label class="finishing-item">
                            <span class="checkbox-box{{ $packagingSpec->uv_plain ? ' checkbox-checked' : '' }}"></span>
                            Plain
                        </label>
                        <label class="finishing-item">
                            <span class="checkbox-box{{ $packagingSpec->uv_spot ? ' checkbox-checked' : '' }}"></span>
                            Spot
                        </label>
                        <label class="finishing-item">
                            <span class="checkbox-box{{ $packagingSpec->uv_drip ? ' checkbox-checked' : '' }}"></span>
                            Drip
                        </label>
                    </div>
                    <div class="finishing-col" style="grid-row:2;grid-column:1;">
                        <div class="col-label">Window:</div>
                        <label class="finishing-item">
                            <span
                                class="checkbox-box{{ $packagingSpec->window_lamination ? ' checkbox-checked' : '' }}"></span>
                            Lamination
                        </label>
                        <label class="finishing-item">
                            <span
                                class="checkbox-box{{ $packagingSpec->window_glass ? ' checkbox-checked' : '' }}"></span>
                            Glass
                        </label>
                    </div>
                    <div class="finishing-col" style="grid-row:2;grid-column:2;">
                        <div class="col-label">Lamination:</div>
                        <label class="finishing-item">
                            <span
                                class="checkbox-box{{ $packagingSpec->shine_lamination ? ' checkbox-checked' : '' }}"></span>
                            Shine
                        </label>
                        <label class="finishing-item">
                            <span
                                class="checkbox-box{{ $packagingSpec->matte_lamination ? ' checkbox-checked' : '' }}"></span>
                            Matt
                        </label>
                        
                    </div>
                </div>




            </div>

            <div class="right-col">
                <div class="box-details">
                    <div class="box-details-title">Box Details</div>
                    <div class="box-detail-row">
                        <span class="spec-label">Glue Flap</span>: <span
                            class="spec-value">{{ $packagingSpec->glue_flap }}</span>
                    </div>
                    <div class="box-detail-row">
                        <span class="spec-label">Folding Flap</span>: <span
                            class="spec-value">{{ $packagingSpec->holding_flap }}</span>
                    </div>
                    <div class="box-detail-row">
                        <span class="spec-label">Pendi</span>: <span
                            class="spec-value">{{ $packagingSpec->pendi }}</span>
                    </div>
                    <div class="box-detail-row">
                        <span class="spec-label">Die Grip</span>: <span
                            class="spec-value">{{ $packagingSpec->die_grip }}</span>
                    </div>
                    <div class="box-detail-row">
                        <span class="spec-label">Die pattern</span>: <span
                            class="spec-value">{{ $packagingSpec->die_pattern }}</span>
                    </div>
                </div>
                <div style="flex:1 1 auto;"></div>
                <div class="diagram-section">
                    @if ($packagingSpec->image_path)
                        @php $ext = pathinfo($packagingSpec->image_path ?? '', PATHINFO_EXTENSION); @endphp
                        @if (strtolower($ext) === 'pdf')
                            <embed src="{{ asset('storage/' . $packagingSpec->image_path) }}" type="application/pdf"
                                class="diagram-img diagram-embed" />
                        @else
                            <img src="{{ asset('storage/' . $packagingSpec->image_path) }}" class="diagram-img">
                        @endif
                    @else
                        <span class="diagram-placeholder">Technical Drawing<br>nill</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
