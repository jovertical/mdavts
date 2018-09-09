@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            List of Elections
        @endslot

        <li class="breadcrumb-item active">
            Elections
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.elections.create') }}">
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
                    <h4 class="card-title">Elections</h4>
                    <h6 class="card-subtitle">
                        This is the list of elections.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-elections" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Actions</th>
                                        <th width="20%">Name</th>
                                        <th width="15%">Start Date</th>
                                        <th width="15%">End Date</th>
                                        <th>Positions</th>
                                        <th>Candidates</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($elections as $election)
                                        <tr>
                                            <td class="text-nowrap">
                                                <a
                                                    href="{{ route('root.elections.edit', $election) }}"
                                                    class="link-edit-election"
                                                    data-toggle="tooltip"
                                                    data-original-title="Edit"
                                                >
                                                    <i class="fas fa-pencil-alt m-r-10"></i>
                                                </a>

                                                <a
                                                    href="{{ route('root.elections.control-numbers.set', $election) }}"
                                                    class="link-set-control-numbers"
                                                    data-toggle="tooltip"
                                                    data-original-title="Generate Control Numbers"
                                                >
                                                    <i class="fas fa-id-card-alt m-r-10"></i>
                                                </a>

                                                <a
                                                    href="{{ route('root.elections.positions.set', $election) }}"
                                                    class="link-set-positions"
                                                    data-toggle="tooltip"
                                                    data-original-title="Set Positions"
                                                >
                                                    <i class="fas fa-tag m-r-10"></i>
                                                </a>

                                                <a
                                                    href="{{ route('root.elections.candidates.set', [$election, 'c' => 8]) }}"
                                                    class="link-set-candidates"
                                                    data-toggle="tooltip"
                                                    data-original-title="Set Candidates"
                                                >
                                                    <i class="fas fa-users m-r-10"></i>
                                                </a>

                                                <a
                                                    href="{{ route('root.elections.tally.show', $election) }}" class="link-show-tally"
                                                    data-toggle="tooltip"
                                                    data-original-title="View Tally"
                                                >
                                                    <i class="fas fa-archive"></i>
                                                </a>
                                            </td>
                                            <td>{{ $election->name }}</td>
                                            <td>{{ $election->start_date }}</td>
                                            <td>{{ $election->end_date }}</td>
                                            <td>{{ optional($election->positions)->count() ?? 0 }}</td>
                                            <td>{{ optional($election->candidates)->count() ?? 0 }}</td>
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

    <form method="POST" action="" id="form-destroy-election" style="display: none;">
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
        $('#table-elections').DataTable({
            "bLengthChange" : false,
        });

        $('.link-destroy-admin').on('click', function(event) {
            var action = $(this).data('action');
            var form = $('#form-destroy-election');
            var modal = $("#modal-confirmation");

            form.attr({action: action});

            modal.modal().on('click', '#btn-modal-confirm', function() {
                form.submit();
            });
        });
    </script>
@endsection
