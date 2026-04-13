@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="page-title">Add Erp Param</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="voucherForm" action="{{ route('erp_param.store') }}" method="POST">
                        @csrf

                        <!-- Account Title Dropdown -->
                        {{-- <input type="hidden" name="account_master_id" value="{{ $accountMasters->id }}"> --}}
                        <div class="mb-3">
                            <label for="accountTitle" class="form-label">Bank Level</label>
                            <select id="ccountTitl" class="form-control" name="bank_level" data-toggle="select2">
                                <option value="">Select Account</option>
                                @foreach ($level2s as $level2)
                                    <option value="{{ $level2->id }}">{{ $level2->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="accountTitle" class="form-label">Cash Level</label>
                            <select id="accountTitl" class="form-control" name="cash_level" data-toggle="select2">
                                <option value="">Select Account</option>
                                @foreach ($level2s as $level2)
                                    <option value="{{ $level2->id }}">{{ $level2->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="accountTitle" class="form-label">Supplier Level</label>
                            <select id="accountTitle" class="form-control" name="supplier_level" data-toggle="select2">
                                <option value="">Select Account</option>
                                @foreach ($level2s as $level2)
                                    <option value="{{ $level2->id }}">{{ $level2->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="accountTitle" class="form-label">Purchase Account</label>
                            <select id="accountTitl" class="form-control" name="purchase_account" data-toggle="select2">
                                <option value="">Select Account</option>
                                @foreach ($accountMasters as $accountMaster)
                                    <option value="{{ $accountMaster->id }}">{{ $accountMaster->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="submitVoucher" class="btn btn-success mt-3">Submit </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
