@extends('layouts.master')
@section('title')
    Update Permission | MDSJEDPR
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
        .form-control {
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
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
        #treeview1 label {
            cursor: pointer;
            padding: 8px 12px;
            margin: 3px 0;
            transition: all 0.3s;
            display: block;
            border-radius: 6px;
        }
        #treeview1 label:hover {
            background: #fff;
            transform: translateX(5px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        #treeview1 input[type="checkbox"] {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        #treeview1 input[type="checkbox"]:checked + * {
            color: #28a745;
            font-weight: 500;
        }
        .btn {
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Permissions</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Update Permission</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please fix the following issues:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Update Permission: <strong>{{ $role->name }}</strong></h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Permission Name <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter permission name', 'required' => true]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="font-weight-bold mb-0">Select Permissions:</h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-success" id="selectAllBtn">
                                        <i class="fas fa-check-double"></i> Select All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning ml-2" id="deselectAllBtn">
                                        <i class="fas fa-times"></i> Deselect All
                                    </button>
                                </div>
                            </div>
                            <ul id="treeview1">
                                <li><a href="#"><i class="fas fa-key"></i> Available Permissions</a>
                                    <ul>
                                        @foreach($permission as $value)
                                            <li>
                                                <label style="font-size: 14px; font-weight: normal;">
                                                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name permission-checkbox', 'data-permission' => $value->name]) }}
                                                    {{ $value->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Permission
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    {!! Form::close() !!}

</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>

<script>
$(document).ready(function() {
    // Define all sections
    const sections = [
        'dashboard', 'epo', 'project-details', 'customer', 'pm', 'am',
        'vendors', 'supplier', 'invoice', 'dn', 'coc', 'pos', 'status',
        'ptasks', 'risks', 'milestones', 'reports',
        'users', 'roles', 'permissions'
    ];

    // Function to update dependent permissions
    function updateDependentPermissions(section) {
        const showCheckbox = $(`.permission-checkbox[data-permission="show ${section}"]`);
        const isShowChecked = showCheckbox.is(':checked');

        // Get all related permissions (add, edit, delete, view)
        const relatedCheckboxes = $(`.permission-checkbox`).filter(function() {
            const permName = $(this).data('permission');
            return (
                permName === `add ${section}` ||
                permName === `edit ${section}` ||
                permName === `delete ${section}` ||
                permName === `view ${section}`
            );
        });

        if (!isShowChecked) {
            // Disable and uncheck related permissions
            relatedCheckboxes.each(function() {
                $(this).prop('disabled', true);
                $(this).prop('checked', false);
                $(this).closest('label').css('opacity', '0.5');
            });
        } else {
            // Enable related permissions
            relatedCheckboxes.each(function() {
                $(this).prop('disabled', false);
                $(this).closest('label').css('opacity', '1');
            });
        }
    }

    // Initialize on page load
    sections.forEach(function(section) {
        updateDependentPermissions(section);
    });

    // Listen to changes on show permissions
    sections.forEach(function(section) {
        $(`.permission-checkbox[data-permission="show ${section}"]`).on('change', function() {
            updateDependentPermissions(section);
        });
    });

    // Prevent clicking on disabled checkboxes
    $('.permission-checkbox').on('click', function(e) {
        if ($(this).prop('disabled')) {
            e.preventDefault();

            // Get section name from permission
            const permName = $(this).data('permission');
            const parts = permName.split(' ');
            const section = parts.slice(1).join(' ');

            alert(`يجب اختيار "show ${section}" أولاً قبل اختيار هذه الصلاحية`);
            return false;
        }
    });

    // Select All Button
    $('#selectAllBtn').on('click', function() {
        // First, select all "show" permissions
        sections.forEach(function(section) {
            const showCheckbox = $(`.permission-checkbox[data-permission="show ${section}"]`);
            showCheckbox.prop('checked', true);
            updateDependentPermissions(section);
        });

        // Then select all enabled permissions
        $('.permission-checkbox:not(:disabled)').prop('checked', true);
    });

    // Deselect All Button
    $('#deselectAllBtn').on('click', function() {
        $('.permission-checkbox').prop('checked', false);

        // Update all sections to disable dependent permissions
        sections.forEach(function(section) {
            updateDependentPermissions(section);
        });
    });
});
</script>
@endsection
