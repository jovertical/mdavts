@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            List of Positions
        @endslot

        <li class="breadcrumb-item active">
            Positions
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.positions.create') }}">
                <button type="submit" class="btn btn-info btn-loading float-right">
                    <i class="fas fa-plus"></i> Create
                </button>
            </form>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Positions</h4>
                    <h6 class="card-subtitle">
                        This is the list of positions that an election can have.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-positions" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Actions</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Elections</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($positions as $position)
                                        <tr>
                                            <td class="text-nowrap">
                                                <a href="{{ route('root.positions.edit', $position) }}" class="link-edit-position"
                                                    data-toggle="tooltip" data-original-title="Edit">
                                                    <i class="fas fa-pencil-alt m-r-10"></i>
                                                </a>

                                                <a href="#" data-action="{{ route('root.positions.destroy', $position) }}" class="link-destroy-position"
                                                    data-toggle="tooltip" data-original-title="Delete">
                                                    <i class="fas fa-window-close text-danger"></i>
                                                </a>
                                            </td>
                                            <td>{{ $position->name }}</td>
                                            <td>{{ $position->level }}</td>
                                            <td>{{ optional($position->elections)->count() ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="" id="form-destroy-position" style="display: none;">
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
        $('#table-positions').DataTable({
            "bLengthChange" : false,
        });

        $('.link-destroy-position').on('click', function(event) {
            var action = $(this).data('action');
            var form = $('#form-destroy-position');
            var modal = $("#modal-confirmation");

            form.attr({action: action});

            modal.modal().on('click', '#btn-modal-confirm', function() {
                form.submit();
            });
        });
    </script>
@endsection