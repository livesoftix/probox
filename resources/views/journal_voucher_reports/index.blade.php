@extends('layouts.app')
@section('content')
    <style>
        :root[data-bs-theme="light"] {
            --text: #040809;
            --background: #f7fbfb;
            --primary: #58a3b3;
            --secondary: #aa9dd2;
            --accent: #ae83c7;
        }

        :root[data-bs-theme="dark"] {
            --text: #f4f9fa;
            --background: #030707;
            --primary: #4d97a8;
            --secondary: #3a2d62;
            --accent: #62377b;
        }

        body {
            background-color: var(--background);
            color: var(--text);
        }

        .page-title-box h4,
        .header-title {
            color: var(--primary);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .btn-secondary {
            background-color: var(--secondary);
            border-color: var(--secondary);
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
            color: #fff;
        }

        .card {
            background-color: var(--background);
            border: 1px solid var(--secondary);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        table th {
            background-color: var(--secondary);
            color: #fff;
        }

        table td {
            color: var(--text);
        }

        .breadcrumb-item a {
            color: var(--accent);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--primary);
        }
    </style>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">ProBox</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Tables</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Journal Voucher</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
                {{ session('success') }}
            </div>
        @endif
        <!-- Search Form -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <div class="col-12">
                    <form action="{{ route('journal_voucher.reports') }}" method="GET" id="search-form">
                        <div class="row g-2 align-items-end">

                            {{-- Start Date --}}
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ request()->get('start_date') }}">
                            </div>

                            {{-- End Date --}}
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    value="{{ request()->get('end_date') }}">
                            </div>

                            {{-- Voucher Number --}}
                            <div class="col-md-3">
                                <label for="v_no" class="form-label">Voucher Number</label>
                                <select name="v_no" class="form-select select2" data-toggle="select2">
                                    <option value="">Select Voucher</option>
                                    @foreach ($vNoList as $vNo)
                                        <option value="{{ $vNo }}" {{ request()->get('v_no') == $vNo ? 'selected' : '' }}>
                                            {{ $vNo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-3">
                                <label for="description" class="form-label">Description</label>
                                <select name="description" class="form-select select2" data-toggle="select2">
                                    <option value="">Select Description</option>
                                    @foreach ($descriptionList as $desc)
                                        <option value="{{ $desc }}" {{ request()->get('description') == $desc ? 'selected' : '' }}>
                                            {{ $desc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Buttons --}}
                            <div class="col-md-12 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a class="btn btn-success" href="{{ route('journal_voucher.list') }}"
                                    onclick="return checkPermission()">
                                    Add New
                                </a>
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
            <div class="card">
                <div class="card-body">
                    <div id="print-header" style="display:none;">
                        <h3>Journal Voucher Details</h3>
                        <h5>Start Date: <span id="display-start-date">{{ request()->get('start_date') ?? 'N/A' }}</span>
                        </h5>
                        <h5>End Date: <span id="display-end-date">{{ request()->get('end_date') ?? date('Y-m-d') }}</span>
                        </h5>
                    </div>

                    <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print
                        Table</button>
                    <div class="card mt-2">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="col-12">

                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">

                                        <h5>Start Date: {{ request()->get('start_date') ?? 'N/A' }} | End Date:
                                            {{ request()->get('end_date') ?? date('Y-m-d') }}</h5>

                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>V. No</th>
                                                <th>Account Title</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                                <th>Description</th>
                                                <th class="no-print">Status</th>
                                                <th class="no-print">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($trndtls as $trndtl)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($trndtl->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $trndtl->v_type }}-{{ $trndtl->v_no }}</td>
                                                    <td>{{ $trndtl->accounts->title ?? 'N/A' }}</td>
                                                    <!-- Corrected relation -->
                                                    <td>{{ $trndtl->debit }}</td>
                                                    <td>{{ $trndtl->credit }}</td>
                                                    <td>{{ $trndtl->description ?? 'N/A' }}</td>
                                                    <td class="no-print">
                                                        <input type="checkbox" class="status-checkbox"
                                                            data-id="{{ $trndtl->id }}"
                                                            {{ $trndtl->status == 'official' ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="no-print">
                                                        <!-- Edit button -->
                                                        <a href="{{ route('journal_voucher.edit', $trndtl->v_no) }}"
                                                            class="btn btn-warning btn-sm"
                                                            onclick="return checkPermissionEdit()">Edit</a>

                                                        <!-- Delete button (use form for method spoofing) -->
                                                        <form
                                                            action="{{ route('journal_voucher.destroy', $trndtl->v_no) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onclick="return checkPermissionDel()">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete the entire voucher JV-{{ $trndtl->v_no }}?')">
                                                                Delete Voucher
                                                            </button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        // === Set today's date in End Date input ===
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('end_date').value = today;

        // === Print Table Function ===
        function printTable() {
            // Hide elements with 'no-print' class
            const elementsToHide = document.querySelectorAll('.no-print');
            elementsToHide.forEach(el => el.style.display = 'none');

            // Get all headings (both h4 and h5) and table content
            const headings = document.querySelectorAll('.col-12 h4, .col-12 h5');
            let headingsContent = '';
            headings.forEach(heading => {
                headingsContent += heading.outerHTML;
            });

            const tableContent = document.getElementById('basic-datatable').outerHTML;
            const originalContents = document.body.innerHTML;

            // Replace body content with the headings and table HTML for printing
            document.body.innerHTML = `
            <html>
                <head>
                    <title>Print Table</title>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                        }
                        th {
                            background-color: #f2f2f2;
                            text-align: left;
                        }
                        .no-print {
                            display: none;
                        }
                        h4, h5 {
                            margin: 5px 0;
                        }
                    </style>
                </head>
                <body>
                    ${headingsContent}
                    ${tableContent}
                </body>
            </html>
        `;

            // Trigger print dialog
            window.print();

            // Restore the original page content after printing
            document.body.innerHTML = originalContents;

            // Reload to reattach event listeners
            window.location.reload();
        }

        // === Status Checkbox AJAX Update ===
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".status-checkbox").forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    let id = this.dataset.id;
                    let isChecked = this.checked ? 'official' : 'unofficial';

                    fetch(`/journal-voucher/update-status/${id}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute("content"),
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                status: isChecked
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log(`Status updated: ${data.status}`);
                            } else {
                                alert("Failed to update status!");
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert("status updated.");
                        });
                });
            });
        });
    </script>
@endsection
