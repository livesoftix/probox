@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right">

                    <a href="{{ route('product-freezing.index') }}"
                       class="btn btn-dark">

                        Back

                    </a>

                </div>

                <h4 class="page-title">

                    View Product Freezing

                </h4>

            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <!-- Date -->

                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Date
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ date('d-m-Y',strtotime($productFreezing->date)) }}"
                                readonly>

                        </div>

                        <!-- Slip -->

                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Slip No
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $productFreezing->slip_no }}"
                                readonly>

                        </div>

                        <!-- Product -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Product
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $productFreezing->product->prod_name }}"
                                readonly>

                        </div>

                        <!-- Status -->

                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="Inactive"
                                readonly>

                        </div>

                        <!-- Description -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea
                                rows="5"
                                class="form-control"
                                readonly>{{ $productFreezing->description }}</textarea>

                        </div>

                    </div>

                    <hr>

                    <a href="{{ route('product-freezing.edit',$productFreezing->id) }}"
                       class="btn btn-warning">

                        Edit

                    </a>

                    <a href="{{ route('product-freezing.print',$productFreezing->id) }}"
                       target="_blank"
                       class="btn btn-success">

                        Print

                    </a>

                    <a href="{{ route('product-freezing.index') }}"
                       class="btn btn-secondary">

                        Close

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection