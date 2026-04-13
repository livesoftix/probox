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
                    <h4 class="page-title">Level1</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Success - </strong> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-12">
                <a href="{{ route('level1.create') }}" onclick="return checkPermission()">
    <button type="button" class="btn btn-primary">Add Level1</button>
</a>


                <button type="button" class="btn btn-secondary" onclick="printTable()">Print Table</button>
                <!-- Print Button -->
                <div class="card mt-2">
                    <div class="card-body">
                        <h4 class="header-title">Level1</h4>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-datatable-preview">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Level1 Title</th>
                                            <th>Group Title</th>
                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($level1s as $level1)
                                            <tr>
                                                <td>{{ $level1->id }}</td>
                                                <td>{{ $level1->title }}</td>
                                                <td>{{ $level1->groups->title }}</td>
                                                <td class="no-print">
                                                    <div class="d-flex">
                                                        <a href="{{ route('level1.edit', $level1->id) }}">
                                                            <button type="button" class="btn btn-primary"  onclick="return checkPermissionEdit()">Edit</button>
                                                        </a>
                                                        <form action="{{ route('level1.destroy', $level1->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                style="margin-left: 2px;" onclick="return checkPermissionDel()">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div> <!-- end row-->
    </div>

    <!-- Print Function -->
    <script>
    function checkPermission() {
        @php
        $isAdmin = auth()->user()->is_admin;
        $canAdd = true;

        if ($isAdmin == 0) {
            $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                ->where('app_name', 'Level1')
                ->first();
            $canAdd = $userRights && $userRights->add == 1;
        }
    @endphp
        
        if (!@json($canAdd)) {
            alert('You do not have Permission to Add');
            return false; // Prevent the default action (navigation)
        }
        return true; // Allow navigation
    }
    
    
    function checkPermissionEdit() {
        @php
        $isAdmin = auth()->user()->is_admin;
        $canAdd = true;

        if ($isAdmin == 0) {
            $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                ->where('app_name', 'Level1')
                ->first();
            $canAdd = $userRights && $userRights->edit == 1;
        }
    @endphp
        
        if (!@json($canAdd)) {
            alert('You do not have Permission to Edit');
            return false; // Prevent the default action (navigation)
        }
        return true; // Allow navigation
    }
    
    function checkPermissionDel() {
       @php
        $isAdmin = auth()->user()->is_admin;
        $canAdd = true;

        if ($isAdmin == 0) {
            $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                ->where('app_name', 'Level1')
                ->first();
            $canAdd = $userRights && $userRights->del== 1;
        }
    @endphp
        
        if (!@json($canAdd)) {
            alert('You do not have Permission to Delete');
            return false; // Prevent the default action (navigation)
        }
        return true; // Allow navigation
    }
    
    
        function printTable() {
            // Hide elements with 'no-print' class
            const elementsToHide = document.querySelectorAll('.no-print');
            elementsToHide.forEach(el => el.style.display = 'none');

            const printContents = document.getElementById('basic-datatable').outerHTML;
            const originalContents = document.body.innerHTML;

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
                            .no-print{
                                background-color: #f2f2f2;
                            }
                        </style>
                    </head>
                    <body>
                        ${printContents}
                    </body>
                </html>
            `;

            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload(); // Reload to restore the original page content
        }
    </script>
@endsection
