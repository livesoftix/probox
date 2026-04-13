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
                    <h4 class="page-title">Chart Of Account</h4>
                </div>
            </div>

        </div>


<div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                           <form action="{{ route('amaster.list') }}" method="GET" class="form-inline col-xl-12" id="search-form">
    <div class="row">
       <div class="form-group col-xl-3">
    <label for="title" class="sr-only">Title</label>
    <select name="title" class="form-control select2" data-toggle="select2">
        <option value="">Select Title</option>
        @foreach($titles as $vNo)
            <option value="{{ $vNo }}" {{ request()->get('title') == $vNo ? 'selected' : '' }}>
                {{ $vNo }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-xl-3">
    <label for="level2_id" class="sr-only">Level 2</label>
    <select name="level2_id" class="form-control select2" data-toggle="select2">
        <option value="">Select Level</option>
        @foreach($level2s as $level2)
            <option value="{{ $level2->id }}" {{ request()->get('level2_id') == $level2->id ? 'selected' : '' }}>
                {{ $level2->title }}
            </option>
        @endforeach
    </select>
</div>

    </div>
    <div class="form-group col-xl-3 mt-2">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('amaster.list') }}" class="btn btn-secondary">Clear</a>
    </div>
</form>
                        </div>
                    </div>
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
              
                
               
                <!-- Print Button -->
                <div class="card mt-2">
                    <div class="card-body">
                         <a href="{{ route('amaster.create') }}"><button type="button" class="btn btn-primary" onclick="return checkPermission()" >Add
                        Account</button></a>
                <button type="button" class="btn btn-secondary" onclick="printTable()">Print Table</button>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-datatable-preview">
                                <!-- First Table (Hidden during Print) -->
                                <table id="first-table" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Account Title</th>
                                            <th>Level2 Title</th>
                                            <th>Opening Date</th>
                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($account_masters as $account_master)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $account_master->title }}</td>
                                                <td>{{ $account_master->level2s->title }}</td>
                                                <td>{{ $account_master->opening_date }}</td>
                                                <td class="no-print">
                                                    <div class="d-flex">
                                                        <a href="{{ route('amaster.edit', $account_master->id) }}">
                                                            <button type="button" class="btn btn-primary" onclick="return checkPermissionEdit()" >Edit</button>
                                                        </a>



                                                        <form action="{{ route('amaster.destroy', $account_master->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                style="margin-left: 2px;" onclick="return checkPermissionDel()" >Delete</button>
                                                        </form>


                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div> <!-- end row-->

        <!-- Second Table (This will be Printed) -->
        <table id="second-table" class="table table-striped dt-responsive nowrap w-100" style="display: none;">
            <thead>
                <tr>
                    <th style="width: 160px;">Account Code</th>
                    <th class="text-start">Account Title</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Prepare and sort the data recursively
                    $sortedGroups = $groups
                        ->map(function ($group) {
                            $group->level1s = $group->level1s
                                ->map(function ($level1) {
                                    $level1->level2s = $level1->level2s
                                        ->map(function ($level2) {
                                            $level2->AccountMasters = $level2->AccountMasters->sortBy('account_code'); // Sort accounts by Account Code
                                            return $level2;
                                        })
                                        ->sortBy('level2_code'); // Sort level2s by Level2 Code
                                    return $level1;
                                })
                                ->sortBy('level1_code'); // Sort level1s by Level1 Code
                            return $group;
                        })
                        ->sortBy('group_code'); // Sort groups by Group Code
                @endphp

                @foreach ($sortedGroups as $group)
                    @php $zero = 000000; @endphp

                    <!-- Group Row -->
                    <tr style="height: 4px;">
                        <td>{{ $group->group_code }}-00-000-{{ $zero }}</td>
                        <td><strong>{{ $group->title }}</strong></td>
                    </tr>

                    @foreach ($group->level1s as $level1)
                        <!-- Level 1 Row -->
                        <tr>
                            <td>{{ $group->group_code }}-{{ $level1->level1_code }}-000-0000</td>
                            <td><span style="margin-left: 40px;">{{ $level1->title }}</span></td>
                        </tr>

                        @foreach ($level1->level2s as $level2)
                            <!-- Level 2 Row -->
                            <tr>
                                <td>{{ $group->group_code }}-{{ $level1->level1_code }}-{{ $level2->level2_code }}-0000
                                </td>
                                <td><span style="margin-left: 60px;">{{ $level2->title }}</span></td>
                            </tr>

                            @foreach ($level2->AccountMasters as $account)
                                <!-- Account Row -->
                                <tr>
                                    <td>{{ $group->group_code }}-{{ $level1->level1_code }}-{{ $level2->level2_code }}-{{ $account->account_code }}
                                    </td>
                                    <td><span style="margin-left: 80px;">{{ $account->title }}</span></td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Print Function -->
    <script>
    
     
     function checkPermission() {
        @php
        $isAdmin = auth()->user()->is_admin;
        $canAdd = true;

        if ($isAdmin == 0) {
            $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                ->where('app_name', 'ChartOfAccount')
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
                ->where('app_name', 'ChartOfAccount')
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
                ->where('app_name', 'ChartOfAccount')
                ->first();
            $canAdd = $userRights && $userRights->del == 1;
        }
    @endphp
        if (!@json($canAdd)) {
            alert('You do not have Permission to Delete');
            return false; // Prevent the default action (navigation)
        }
        return true; // Allow navigation
    }
    
    
        function printTable() {
            // Hide the first table and show the second table
            document.getElementById('first-table').style.display = 'none';
            document.getElementById('second-table').style.display = 'table';

            // Get the title dynamically from the page
            const pageTitle = document.querySelector('.page-title').textContent.trim();

            // Get the content of the second table
            const printContents = document.querySelector('#second-table').outerHTML;
            const originalContents = document.body.innerHTML;

            // Set the body content to only the second table and a title for printing
            document.body.innerHTML = `
                <html>
                    <head>
                        <title>${pageTitle}</title>
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
                        </style>
                    </head>
                    <body>
                        <h4>${pageTitle}</h4> <!-- Include the title in the print view -->
                        ${printContents} <!-- Only the second table -->
                    </body>
                </html>
            `;

            window.print(); // Trigger the print dialog

            // Restore the original content after printing
            document.body.innerHTML = originalContents;

            // Show the first table again
            document.getElementById('first-table').style.display = 'table';
            document.getElementById('second-table').style.display = 'none';
        }
    </script>
@endsection
