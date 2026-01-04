@extends('layouts.master')
@section('title')
    Update User | MDSJEDPR
@stop
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

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
                <h4 class="content-title mb-0 my-auto">Users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Update User</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle"></i> Error!</strong> Please fix the following issues:
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

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-user-edit"></i> Update User: <strong class="text-primary">{{ $user->name }}</strong></h5>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">User Name <span class="text-danger">*</span></label>
                                    {!! Form::text('name', null, array('class' => 'form-control','required', 'placeholder' => 'Enter user name')) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                                    {!! Form::text('email', null, array('class' => 'form-control','required', 'placeholder' => 'Enter email address')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-lock"></i> New Password <small class="text-muted">(leave blank to keep current)</small>
                                    </label>
                                    {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter new password', 'autocomplete' => 'new-password')) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-lock"></i> Confirm Password
                                    </label>
                                    {!! Form::password('confirm-password', array('class' => 'form-control', 'placeholder' => 'Confirm new password', 'autocomplete' => 'new-password')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">User Status</label>
                                    <select name="Status" class="form-control nice-select custom-select">
                                        <option value="{{ $user->Status}}">Current: {{ ucfirst($user->Status) }}</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">User Permissions</label>
                                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control select2','multiple')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-save"></i> Update User
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}
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
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select permissions',
                allowClear: true
            });
        });
    </script>
@endsection
