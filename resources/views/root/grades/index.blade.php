@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            List of grades
        @endslot

        <li class="breadcrumb-item active">
            Grades
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.grades.create') }}">
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
                    <h4 class="card-title">Grades</h4>
                    <h6 class="card-subtitle">
                        This is the list of Grades.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <table id="table-grades" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Level</th>
                                    <th>Description</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($grades as $grade)
                                    <tr>
                                        <td class="text-nowrap">
                                            <a
                                                href="{{ route('root.grades.edit', $grade) }}"
                                                class="link-edit-grades"
                                                data-toggle="tooltip"
                                                data-original-title="Edit"
                                            >
                                                <i class="fas fa-pencil-alt m-r-10"></i>
                                            </a>

                                            <a
                                                href="#"
                                                data-action="{{ route('root.grades.destroy', $grade) }}"
                                                class="link-destroy-grade"
                                                data-toggle="tooltip" data-original-title="Delete"
                                            >
                                                <i class="fas fa-window-close text-danger"></i>
                                            </a>
                                        </td>

                                        <td>{{ $grade->level }}</td>
                                        <td>{{ str_limit($grade->description, 25) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="" id="form-destroy-grades" style="display: none;">
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
        $('#table-grades').DataTable({
            "bLengthChange" : false,
        });

        $('.link-destroy-grade').on('click', function(event) {

            var action = $(this).data('action');
            var form = $('#form-destroy-grades');
            var modal = $("#modal-confirmation");

            form.attr({action: action});

            modal.modal().on('click', '#btn-modal-confirm', function() {
                form.submit();

            });
        });
    </script>
@endsection
