@extends('layouts.master')
@section('title')
    View Permission | MDSJEDPR
@stop
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        #treeview1 {
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }
        #treeview1 > li > a {
            font-weight: bold;
            font-size: 16px;
            color: #007bff;
            padding: 10px;
            display: inline-block;
        }
        #treeview1 li li {
            padding: 10px 15px;
            margin: 8px 0;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #28a745;
            transition: all 0.3s;
        }
        #treeview1 li li:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .permission-badge {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            background: linear-gradient(135deg, #e7f3ff 0%, #d4e9ff 100%);
            border-radius: 20px;
            font-size: 14px;
            border-left: 4px solid #007bff;
            transition: all 0.3s;
            cursor: default;
        }
        .permission-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,123,255,0.3);
        }
        .permissions-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        .alert {
            border-radius: 8px;
            border-left: 4px solid #17a2b8;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Permissions</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ View Permission</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm mr-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Edit Permission
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Permission Details: <strong class="text-primary">{{ $role->name }}</strong></h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="font-weight-bold mb-3">Associated Permissions:</h6>
                            @if(!empty($rolePermissions) && $rolePermissions->count() > 0)
                                <div class="permissions-grid">
                                    @foreach($rolePermissions as $permission)
                                        <span class="permission-badge">
                                            <i class="fas fa-check-circle text-success"></i> {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No permissions assigned to this role yet.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="font-weight-bold mb-3">Permissions Tree View:</h6>
                            <ul id="treeview1">
                                <li><a href="#"><i class="fas fa-key"></i> {{ $role->name }}</a>
                                    <ul>
                                        @if(!empty($rolePermissions) && $rolePermissions->count() > 0)
                                            @foreach($rolePermissions as $permission)
                                                <li>{{ $permission->name }}</li>
                                            @endforeach
                                        @else
                                            <li class="text-muted">No permissions assigned</li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
