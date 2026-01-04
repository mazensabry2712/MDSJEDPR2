@extends('layouts.master')
@section('title')
    Users | MDSJEDPR
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <style>
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .btn {
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .badge {
            padding: 6px 12px;
            font-size: 13px;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Users List</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-check-circle"></i> Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-trash-alt"></i> Deleted!</strong> User has been deleted successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title mb-0"><i class="fas fa-users"></i> Users Management</h5>
                        <div>
                            @can('add users')
                                <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">
                                    <i class="fas fa-user-plus"></i> Add User
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-md-nowrap" id="example1" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">#</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th style="width: 120px;">Status</th>
                                    <th style="width: 150px;">Permissions</th>
                                    <th style="width: 150px;">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>
                                            <i class="fas fa-user text-primary"></i>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->Status == 'active' || $user->Status == 'Active')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <span class="badge badge-primary" style="margin: 2px;">
                                                        <i class="fas fa-shield-alt"></i> {{ $v }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="badge badge-secondary">No Role</span>
                                            @endif
                                        </td>

                                        <td>
                                            @can('edit users')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary"
                                                    title="Edit User">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @endcan

                                            @can('delete users')
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                                                    data-toggle="modal" href="#modaldemo8" title="Delete User">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- Modal effects -->
    <div class="modal fade" id="modaldemo8" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger"></i> Delete User</h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.destroy', 'test') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle"></i> Are you sure you want to delete this user?
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <div class="form-group">
                            <label class="font-weight-bold">User Name:</label>
                            <input class="form-control" name="username" id="username" type="text" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /row -->
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
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search users...',
                    search: '',
                    lengthMenu: 'Show _MENU_ users',
                    info: 'Showing _START_ to _END_ of _TOTAL_ users',
                    infoEmpty: 'No users available',
                    paginate: {
                        first: 'First',
                        last: 'Last',
                        next: 'Next',
                        previous: 'Previous'
                    }
                },
                pageLength: 50,
                order: [[0, 'asc']]
            });
        });

        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var user_id = button.data('user_id');
            var username = button.data('username');
            var modal = $(this);
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
        });
    </script>


@endsection
