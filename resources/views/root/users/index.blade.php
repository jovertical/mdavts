@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            List of Users
        @endslot

        <li class="breadcrumb-item active">
            Users
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.users.create') }}">
                <button type="submit" class="btn btn-info float-right">
                    <i class="fa fa-plus"></i> Create
                </button>
            </form>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="table-users" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Learner's Reference Number</th>
                                    <th>Grade Level</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-nowrap">
                                            <a href="{{ route('root.users.edit', $user) }}" class="link-edit-user"
                                                data-toggle="tooltip" data-original-title="Edit">
                                                <i class="fas fa-pencil-alt text-inverse m-r-10"></i>
                                            </a>

                                            <a href="{{ route('root.users.control-numbers', $user) }}" class="link-show-control-numbers" data-toggle="tooltip" data-original-title="Control Numbers">
                                                <i class="fas fa-key text-inverse m-r-10"></i>
                                            </a>

                                            <a href="#" data-action="{{ route('root.users.destroy', $user) }}" class="link-destroy-user"
                                                data-toggle="tooltip" data-original-title="Delete">
                                                <i class="fas fa-window-close text-danger"></i>
                                            </a>
                                        </td>
                                        <td>{{ $user->firstname }}</td>
                                        <td>{{ $user->middlename }}</td>
                                        <td>{{ $user->lastname }}</td>
                                        <td>{{ $user->lrn }}</td>
                                        <td>{{ $user->grade_level }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="" id="form-destroy-user" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('modals')
    @component('root.components.modals.confirmation')
        <p class="text-center">
            You are deleting a resource.

            <br />

            Warning: you cannot undo this action!
        </p>
    @endcomponent
@endsection

@section('scripts')
    <script src="/root/assets/plugins/datatables/datatables.min.js"></script>

    <script>
        $('#table-users').DataTable({
            "bLengthChange" : false,
        });

        $('.link-destroy-user').on('click', function(event) {
            var action = $(this).data('action');
            var form = $('#form-destroy-user');
            var modal = $("#modal-confirmation");

            form.attr({action: action});

            modal.modal().on('click', '#btn-modal-confirm', function() {
                form.submit();
            });
        });
    </script>
@endsection
