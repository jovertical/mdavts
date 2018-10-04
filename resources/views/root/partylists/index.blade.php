@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            List of Positions
        @endslot

        <li class="breadcrumb-item active">
            Party Lists
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.partylists.create') }}">
                <button type="submit" class="btn btn-info float-right">
                    <i class="fas fa-plus"></i> Create
                </button>
            </form>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Party Lists</h4>
                    <h6 class="card-subtitle">
                        This is the list of party lists that are allowed to run in an election.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-positions" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Actions</th>
                                        <th>Party List</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($partylists as $partylist)
                                        <tr>
                                            <td class="text-nowrap">
                                                <a href="{{ route('root.partylists.edit', $partylist) }}" class="link-edit-position"
                                                    data-toggle="tooltip" data-original-title="Edit">
                                                    <i class="fas fa-pencil-alt m-r-10"></i>
                                                </a>

                                                <a href="#" data-action="{{ route('root.partylists.destroy', $partylist) }}" class="link-destroy-position"
                                                    data-toggle="tooltip" data-original-title="Delete">
                                                    <i class="fas fa-window-close text-danger"></i>
                                                </a>
                                            </td>
                                            <td>{{ $partylist->name }}</td>
                                            <td>{{ $partylist->description }}</td>
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
    <script src="/assets/plugins/datatables/datatables.min.js"></script>

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