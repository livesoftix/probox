@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Job Detail</h2>
        <a href="{{ route('packaging-specs.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> New Entry
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control form-control-sm"
                           value="{{ request('date') }}" placeholder="Date">
                </div>
                <div class="col-md-3">
                    <input type="text" name="company_name" class="form-control form-control-sm"
                           value="{{ request('company_name') }}" placeholder="Company Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="item_name" class="form-control form-control-sm"
                           value="{{ request('item_name') }}" placeholder="Item Name">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="fa fa-search"></i> Filter
                    </button>
                    <a href="{{ route('packaging-specs.index') }}" class="btn btn-outline-dark btn-sm">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Company</th>
                    <th>Item</th>
                    <th class="text-center" style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($specs as $spec)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($spec->date)->format('d-m-Y') }}</td>
                        <td>{{ $spec->company_name }}</td>
                        <td>{{ $spec->item_name }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1 justify-content-center flex-nowrap">
                                <a href="{{ route('packaging-specs.show', $spec) }}" 
                                   class="btn btn-icon btn-light btn-sm" title="View">
                                    <i class="uil uil-eye text-primary"></i>
                                </a>
                                <a href="{{ route('packaging-specs.edit', $spec) }}" 
                                   class="btn btn-icon btn-light btn-sm" title="Edit">
                                    <i class="uil uil-edit text-warning"></i>
                                </a>
                                <a href="{{ route('packaging-specs.print', $spec) }}" 
                                   class="btn btn-icon btn-light btn-sm" title="Print" target="_blank">
                                    <i class="uil uil-print text-success"></i>
                                </a>
                                <form action="{{ route('packaging-specs.destroy', $spec) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this packaging spec?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-light btn-sm" title="Delete">
                                        <i class="uil uil-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No packaging specs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

   
    
</div>

{{-- Custom Styling --}}
@push('styles')
<style>
    .btn-icon {
        padding: 2px 5px;
        line-height: 1;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .btn-icon i {
        font-size: 14px;
        vertical-align: middle;
    }

    .btn-icon:hover {
        background-color: #f1f1f1;
    }

    th, td {
        vertical-align: middle !important;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        white-space: nowrap;
    }
</style>
@endpush
@endsection
