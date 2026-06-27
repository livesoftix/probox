@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Data Tables</li>
                    </ol>
                </div>
                <h4 class="page-title">Ledger</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Search Form -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="col-12">
                        <form action="{{ route('ledger.list') }}" method="GET" class="form-inline col-xl-12" id="search-form">
                            <div class="row">
                                <div class="form-group col-xl-3">
                                    <label for="start_date" class="sr-only">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ request()->get('start_date') }}">
                                </div>
                                <div class="form-group col-xl-3">
                                    <label for="end_date" class="sr-only">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ request()->get('end_date') }}">
                                </div>
                                <div class="form-group col-xl-3">
                                    <label for="account_title" class="sr-only">Account Title</label>
                                    <select name="account_title" id="account_title" class="form-control select2"
                                        data-toggle="select2">
                                        <option value="">Select Account</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" {{ isset($accountId) && $accountId==$account->id ? 'selected' : '' }}>
                                            {{ $account->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xl-3">
                                    <label for="account_title" class="sr-only">Status</label>
                                    <select name="status" class="form-control select2">
                                        <option value="">All</option>
                                        <option value="official" {{ $status=='official' ? 'selected' : '' }}>Official</option>
                                        <option value="unofficial" {{ $status=='unofficial' ? 'selected' : '' }}>Unofficial</option>
                                    </select>
                                </div>
                                <div class="col-xl-3">
                                    <button type="submit" class="btn btn-primary mb-2 mt-3">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ledger Table -->
    <div class="row">
        <div class="card mt-2">
            <div class="card-body">

                <div id="print-header" style="display:none;">
                    @php
                    $selectedAccount = $accounts->firstWhere('id', request()->get('account_title'));
                    @endphp
                    <h3>Ledger Details</h3>
                    <div>
                        <h5 style="display: inline-block;">Start Date: 
                            <span id="display-start-date">{{ request()->get('start_date') ?? 'N/A' }}</span>
                        </h5>
                        <h5 style="display: inline-block; float: right;">Name: 
                            <span id="display-party-name">{{ $selectedAccount ? $selectedAccount->title : 'N/A' }}</span>
                        </h5>
                    </div>
                    <h5>End Date: 
                        <span id="display-end-date">{{ request()->get('end_date') ?? date('Y-m-d') }}</span>
                    </h5>
                </div>

                <!-- Buttons -->
                <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print</button>
                <button type="button" class="btn btn-success" style="width: 120px;" onclick="downloadPDF()">Download</button>
                <button type="button" class="btn btn-success" onclick="downloadJPG()">Download JPG</button>

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="ledger">
                                <div>
                                    <h3>Ledger Details</h3>
                                    <div>
                                        <h4 style="display: inline-block;">Start Date: 
                                            <span id="display-start-date">
                                                @if(request()->get('start_date'))
                                                    {{ date_format(date_create(request()->get('start_date')), 'd-m-Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>  ||
                                        </h4>
                                        <h4 style="display: inline-block;">End Date: 
                                            <span id="display-end-date">
                                                @if(request()->get('end_date'))
                                                    {{ date_format(date_create(request()->get('end_date')), 'd-m-Y') }}
                                                @else
                                                    {{ date('d-m-Y') }}
                                                @endif
                                            </span>
                                        </h4>
                                    </div>
                                </div>

                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Voucher Type</th>
                                            <th>Description</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th colspan="3" class="text-end">Opening Balance</th>
                                            <th></th>
                                            <th></th>
                                            <th>
                                                @if ($openingBalance >= 0)
                                                    {{ number_format(($openingBalance), 2) }} Dr
                                                @else
                                                    {{ number_format(($openingBalance), 2) }} Cr
                                                @endif
                                            </th>
                                        </tr>
                                        @php
                                        $runningTotal = $openingBalance;
                                        $totalDebit = 0;
                                        $totalCredit = 0;
                                        $sortedTrndtls = $trndtls->sortBy('date');
                                        @endphp

                                        @foreach ($sortedTrndtls as $trndtl)
                                        @php
                                            $debit = $trndtl->debit;
                                            $credit = $trndtl->credit;

                                            if ($trndtl->cash_id == $accountId && $trndtl->account_id != $accountId) {
                                                $credit = $trndtl->debit;
                                                $debit = $trndtl->credit;
                                            }

                                            $totalDebit += $debit;
                                            $totalCredit += $credit;
                                            $difference = $debit - $credit;
                                            $runningTotal += $difference;
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($trndtl->date)->format('d-m-Y') }}</td>
                                            <td>{{ $trndtl->v_type }}-{{ $trndtl->v_no }}</td>
                                            <td>{{ $trndtl->description }}</td>
                                            <td>{{ number_format($debit, 2) }}</td>
                                            <td>{{ number_format($credit, 2) }}</td>
                                            <td>
                                                @if ($runningTotal > 0)
                                                    {{ number_format($runningTotal, 2) }} Dr
                                                @elseif ($runningTotal < 0)
                                                    {{ number_format(abs($runningTotal), 2) }} Cr
                                                @else
                                                    {{ number_format($runningTotal, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        <tr>
                                            <th colspan="3" class="text-end">Total:</th>
                                            <td>{{ number_format($totalDebit, 2) }}</td>
                                            <td>{{ number_format($totalCredit, 2) }}</td>
                                            <td>
                                                @if ($runningTotal > 0)
                                                    {{ number_format($runningTotal, 2) }} Dr
                                                @elseif ($runningTotal < 0)
                                                    {{ number_format(abs($runningTotal), 2) }} Cr
                                                @else
                                                    {{ number_format($runningTotal, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- inner card -->
            </div>
        </div>
    </div>
</div>

<!-- jsPDF libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
const today = new Date();
const endDate = formatDate(today);
const startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));

const startInput = document.getElementById('start_date');
const endInput = document.getElementById('end_date');

if (!startInput.value) startInput.value = startDate;
if (!endInput.value) endInput.value = endDate;

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function printTable() {
    const elementsToHide = document.querySelectorAll('.no-print');
    elementsToHide.forEach(el => el.style.display = 'none');

    const hiddenDiv = document.querySelector('div[style="display:none;"]');
    const headingContent = hiddenDiv.querySelector('h3').outerHTML;
    const subHeadings = hiddenDiv.querySelectorAll('h5');
    const subHeadingContent = Array.from(subHeadings).map(h5 => h5.outerHTML).join('');

    const printContents = document.getElementById('basic-datatable').outerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
            <head>
                <title>Print Table</title>
                <style>
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; }
                    th { background-color: #f2f2f2; text-align: left; }
                </style>
            </head>
            <body>
                ${headingContent}
                ${subHeadingContent}
                ${printContents}
            </body>
        </html>
    `;

    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
}

function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(14);
    doc.text("Ledger Details", 14, 15);

    const startDate = document.getElementById("display-start-date")?.innerText || "N/A";
    const endDate = document.getElementById("display-end-date")?.innerText || "N/A";
    const partyName = document.getElementById("display-party-name")?.innerText || "N/A";

    doc.setFontSize(10);
    doc.text(`Start Date: ${startDate}`, 14, 25);
    doc.text(`End Date: ${endDate}`, 100, 25);
    doc.text(`Name: ${partyName}`, 14, 32);

    doc.autoTable({
        html: '#basic-datatable',
        startY: 40,
        styles: { fontSize: 9, cellPadding: 2 },
        headStyles: { fillColor: [52, 73, 94], textColor: 255 },
    });

    doc.save(`ledger_${partyName}_${startDate}_to_${endDate}.pdf`);
}
function downloadJPG() {

    const table = document.getElementById('basic-datatable');
    const header = document.getElementById('print-header');

    if (!table) {
        alert('Table not found');
        return;
    }

    // Clone header + table (DON'T use hidden original directly)
      const wrapper = document.createElement('div');
wrapper.id = "capture-wrapper";
    wrapper.style.background = "#ffffff";
    wrapper.style.padding = "15px";
    wrapper.style.width = "1000px";

    // Clone header and show it
    let headerClone = header.cloneNode(true);
    headerClone.style.display = "block";

    // Format header properly
    headerClone.style.marginBottom = "10px";

    // Clone table
    let tableClone = table.cloneNode(true);

    // Fix table styling
    tableClone.style.width = "100%";
    tableClone.style.borderCollapse = "collapse";

    tableClone.querySelectorAll("th, td").forEach(el => {
        el.style.border = "1px solid #000";
        el.style.padding = "6px";
        el.style.fontSize = "10px";
        el.style.textAlign = "center";
    });

    tableClone.querySelectorAll("th").forEach(el => {
        el.style.background = "#f2f2f2";
        el.style.fontWeight = "bold";
    });

    wrapper.appendChild(headerClone);
    wrapper.appendChild(tableClone);

    document.body.appendChild(wrapper);

    setTimeout(() => {
           wrapper.querySelectorAll("*").forEach(el => {
    el.style.setProperty("color", "#000", "important");
    el.style.setProperty("font-family", "Arial, sans-serif", "important");
});

// HEADINGS / TH (VERY IMPORTANT)
wrapper.querySelectorAll("th, h1, h2, h3").forEach(el => {
    el.style.setProperty("color", "#000", "important");
    el.style.setProperty("font-weight", "800", "important");
    el.style.setProperty("font-size", "20px", "important"); // 👈 increase here
});

// TD CONTENT
wrapper.querySelectorAll("td").forEach(el => {
    el.style.setProperty("font-size", "14px", "important");
    el.style.setProperty("color", "#000", "important");
});

// TABLE GLOBAL SIZE
wrapper.querySelectorAll("table").forEach(tbl => {
    tbl.style.setProperty("font-size", "14px", "important");
     tbl.style.setProperty("color", "#000", "important");
});

        html2canvas(wrapper, {
            scale: 3,
            useCORS: true,
            backgroundColor: "#ffffff"
        }).then(canvas => {

            const link = document.createElement('a');
            link.download = "ledger.jpg";
            link.href = canvas.toDataURL("image/jpeg", 1.0);

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            document.body.removeChild(wrapper);
        });

    }, 500);
}
</script>
@endsection
