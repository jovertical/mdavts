@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Control Numbers
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Control-Numbers
        </li>

        @slot('action')
            <div class="row float-right">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-cog mr-1"></i> Actions
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">
                        <a
                            type="button"
                            id="btn-export"
                            class="dropdown-item"
                            data-toggle="modal"
                            data-target="#modal-export"
                            {{ $election->status != 'closed'  ? 'disabled' : '' }}
                        >
                            <i class="fas fa-download mr-1"></i> Export
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('root.elections.control-numbers.create', $election) }}">
                    <button type="submit" class="btn btn-info float-right">
                        <i class="fas fa-plus"></i> Create
                    </button>
                </form>
            </div>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Election Control Numbers</h4>
                    <h6 class="card-subtitle">
                        This is the list of control numbers (of voters) that can be used for this election.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-control_numbers" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Voter</th>
                                        <th>Grade</th>
                                        <th>Section</th>
                                        <th>Number</th>
                                        <th>Used</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($control_numbers as $cn)
                                        <tr>
                                            <td>
                                                <a href="{{ route('root.users.edit', $cn->user) }}">
                                                    {!! $cn->user->full_name_formal ?? '<i>No Data</i>'  !!}
                                                </a>
                                            </td>
                                            <td>
                                                @if (empty($cn->user->grade)) 
                                                    <i>No Data</i>
                                                @else
                                                    <a href="{{ route('root.grades.edit', optional($cn->user)->grade) }}">
                                                        {!! optional($cn->user->grade)->level !!}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if (empty($cn->user->section)) 
                                                    <i>No Data</i>
                                                @else
                                                    <a href="{{ route('root.sections.edit', optional($cn->user)->section) }}">
                                                        {!! optional($cn->user->section)->name !!}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{!! $cn->number ?? '<i>No Data</i>'  !!}</td>
                                            <td>
                                                @unless ($cn->used)
                                                    <span class="label label-rounded label-danger">
                                                        No
                                                    </span>
                                                @else
                                                    <span class="label label-rounded label-success">
                                                        Yes
                                                    </span>
                                                @endunless
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
    </div>
@endsection

@section('modals')
    <div id="modal-export" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('root.elections.control-numbers.export', $election) }}" class="form-material">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">
                            Export Control Numbers
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="modal-body">
                        <!-- File Name -->
                        <div class="form-group">
                            <label for="file_name">File Name</label>

                            <input
                                type="text"
                                name="file_name"
                                id="file_name"
                                class="form-control form-control-line"
                                value="{{ "{$election->name}-Control-Numbers--".now()->format('Y-m-d') }}"
                                placeholder="Enter File Name"
                            >
                        </div>
                        <!--/. File Name -->

                        <!-- File Type -->
                        <div class="form-group">
                            <label for="file_type">File Type</label>

                            <select name="file_type" id="file_type" class="form-control">
                                <option selected disabled>Please select a file type</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                        <!--/. File Type -->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btn-modal-export" class="btn btn-info waves-effect">Export</button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/assets/plugins/datatables/datatables.min.js"></script>

    <script>
        $('#table-control_numbers').DataTable({
            "bLengthChange" : false,
        });
    </script>
@endsection