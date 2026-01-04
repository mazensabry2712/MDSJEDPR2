@extends('layouts.master')
@section('title')
    User Permissions | MDSJEDPR
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <style>
        /* Export buttons styling */
        .export-buttons .btn {
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .export-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .btn-group {
                margin-bottom: 10px;
                margin-right: 0 !important;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ User Permissions</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-check-circle"></i> Success!</strong> User Permission has been added successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Updated!</strong> Permission data has been successfully updated.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-trash-alt"></i> Deleted!</strong> Permission has been successfully deleted.
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
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title mb-0"><i class="fas fa-shield-alt"></i> User Permissions Management</h5>
                        <div>
                            @can('add roles')
                                <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">
                                    <i class="fas fa-plus-circle"></i> Add Permission
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-striped table-bordered table-hover text-md-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">#</th>
                                    <th>Permission Name</th>
                                    <th style="width: 250px;">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td>
                                            <i class="fas fa-key text-primary"></i>
                                            <strong>{{ $role->name }}</strong>
                                        </td>
                                        <td>
                                            @can('view roles')
                                                <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}" title="View Details">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            @endcan

                                            @can('edit roles')
                                                <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}" title="Edit Permission">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @endcan

                                            @if ($role->name !== 'owner')
                                                @can('delete roles')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Permission"
                                                            onclick="return confirm('Are you sure you want to delete this permission?')">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    {!! Form::close() !!}
                                                @endcan
                                            @else
                                                <span class="badge badge-warning" title="Owner permission cannot be deleted">
                                                    <i class="fas fa-lock"></i> Protected
                                                </span>
                                            @endif
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
    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search permissions...',
                    search: '',
                    lengthMenu: 'Show _MENU_ permissions',
                    info: 'Showing _START_ to _END_ of _TOTAL_ permissions',
                    infoEmpty: 'No permissions available',
                    infoFiltered: '(filtered from _MAX_ total permissions)',
                    paginate: {
                        first: 'First',
                        last: 'Last',
                        next: 'Next',
                        previous: 'Previous'
                    }
                },
                pageLength: 10,
                order: [[0, 'asc']]
            });
        });
    </script>
@endsection
