@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            List of Sections
        @endslot

        <li class="breadcrumb-item active">
            Sections
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.sections.create') }}">
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
                    <h4 class="card-title">Sections</h4>
                    <h6 class="card-subtitle">
                        This is the list of Sections
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-sections" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Actions</th>
                                        <th>Grade</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($sections as $section)
                                        <tr>
                                            <td class="text-nowrap">
                                                <a href="{{ route('root.sections.edit', $section) }}" class="link-edit-section"
                                                    data-toggle="tooltip" data-original-title="Edit">
                                                    <i class="fas fa-pencil-alt m-r-10"></i>
                                                </a>

                                                <a href="#" data-action="{{ route('root.sections.destroy', $section) }}" class="link-destroy-section"
                                                    data-toggle="tooltip" data-original-title="Delete">
                                                    <i class="fas fa-window-close text-danger"></i>
                                                </a>
                                            </td>

                                            <td>{{ optional($section->grade)->level }}</td>
                                            <td>{{ $section->name }}</td>
                                            <td>{{ str_limit($section->description, 25) }}</td>
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

    <form method="POST" action="" id="form-destroy-section" style="display: none;">
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
        $('#table-sections').DataTable({
            "bLengthChange" : false,
        });

        $('.link-destroy-section').on('click', function(event) {
            var action = $(this).data('action');
            var form = $('#form-destroy-section');
            var modal = $("#modal-confirmation");

            form.attr({action: action});

            modal.modal().on('click', '#btn-modal-confirm', function() {
                form.submit();
            });
        });
    </script>
@endsection
