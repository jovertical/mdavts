@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Tally
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Tally
        </li>

        @slot('action')
            <button
                type="button"
                id="btn-generate"
                class="btn btn-info float-right"
                data-toggle="modal"
                data-target="#modal-generate"
                {{ now()->format('Y-m-d') < $election->end_date ? 'disabled' : '' }}
            >
                <i class="fas fa-balance-scale"></i> Generate
            </button>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Tally in {{ $election->name }}
                    </h4>
                    <h6 class="card-subtitle">
                        This is the list of tally grouped by position
                    </h6>

                    <form method="GET" action="" class="form-material" submit-once>
                        <div class="row">
                            <div class="col-md">
                                <!-- Position -->
                                <div class="form-group">
                                    <label for="position">Position</label>

                                    <select name="position" id="position" class="form-control">
                                        <option value="" {{ Request::input('position') == null ? 'selected disabled' : '' }}>All</option>

                                        @foreach ($election->positions as $position)
                                            <option
                                                value="{{ $position->uuid_text }}"
                                                {{ Request::input('position') == $position->uuid_text ? 'selected disabled' : '' }}
                                            >
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--/. Position -->
                            </div>
                        </div>

                        <div class="row">
                            <!-- Submit -->
                            <div class="col-md">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-loading">
                                        <i class="fa fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                            <!--/. Submit -->
                        </div>
                    </form>
                </div>
            </div>

            @foreach ($archives as $stats)
                <div class="card">
                    <div class="card-header">
                        Tally for {{ $stats['position']->name }}
                        <div class="card-actions">
                            <a class="" data-action="collapse">
                                <i class="ti-minus"></i>
                            </a>
                            <a class="btn-minimize" data-action="expand">
                                <i class="mdi mdi-arrow-expand"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body collapse show">
                        <div class="table-responsive m-t-40">
                            <div>
                                <table id="table-tally" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Candidate</th>
                                            <th>Vote Count</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach(collect($stats['votes'])->sortByDesc('votes') as $vote)
                                            <tr>
                                                <td>{{ str_limit($vote->candidate->full_name_formal, 25) }}</td>
                                                <td>{{ $vote->votes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modals')
    <div id="modal-generate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="" class="form-material">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">
                            Generate Results
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
                                value="{{ "{$election->name}-Results--".now()->format('Y-m-d') }}"
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
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                        <!--/. File Type -->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btn-modal-generate" class="btn btn-info waves-effect">Generate</button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection