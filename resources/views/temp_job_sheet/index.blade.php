@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- PAGE TITLE --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Job Sheet List</h4>
            </div>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTER SECTION --}}
    <div class="card mt-2">
        <div class="card-body">

            <form action="{{ route('general_job_sheet.report') }}" method="GET">
                <div class="row">

                    {{-- START DATE --}}
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ request('start_date') }}">
                    </div>

                    {{-- END DATE --}}
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ request('end_date') }}">
                    </div>

                    {{-- V NO --}}
                    <div class="col-md-3">
                        <label>JS No</label>
                        <select name="v_no" class="form-control select2">
                            <option value="">All</option>
                            @foreach($vNos as $vNo)
                                <option value="{{ $vNo }}" {{ request('v_no') == $vNo ? 'selected' : '' }}>
                                    TJS-{{ $vNo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PARTY --}}
                    <div class="col-md-3">
                        <label>Party</label>
                        <select name="account_id" class="form-control select2">
                            <option value="">All</option>
                            @foreach($accountIds as $id => $title)
                                <option value="{{ $id }}" {{ request('account_id') == $id ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('tempjob.list') }}" class="btn btn-success">Add New</a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- TABLE SECTION --}}
    <div class="card mt-2">
        <div class="card-body">

            <button class="btn btn-secondary mb-2" onclick="printTable()">Print</button>

            <div id="print-area" class="table-responsive">

                <table class="table table-bordered table-striped w-100">

                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>V No</th>
                            <th>Job Name</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <!-- <th>Party</th> -->
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($generalJobSheets as $job)
                            <tr>
                                <td>{{ $job->date }}</td>
                                <td>TJS-{{ $job->v_no }}</td>
                                <td>{{ $job->job_name }}</td>
                                <td>{{ $job->size }}</td>
                                <td>{{ $job->qty }}</td>
                                <!-- <td>{{ $job->account->title ?? 'N/A' }}</td> -->
                                <td>{{ $job->note }}</td>

                                <td>
                                    <form action="{{ route('tempjob.destroy', $job->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

{{-- PRINT SCRIPT --}}
<script>
function printTable() {
    const printContents = document.getElementById('print-area').innerHTML;

    const w = window.open('', '', 'width=900,height=700');

    w.document.write(`
        <html>
        <head>
            <title>Print Job Sheet</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                }
                th {
                    background: #eee;
                }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `);

    w.document.close();
    w.print();
}
</script>

@endsection