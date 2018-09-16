@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Dashboard
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Dashboard
        </li>
    @endcomponent

    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col p-r-0 align-self-center">
                        <h2 class="font-light m-b-0">{{ $stats['votes_today']['value'] }}</h2>
                        <h6 class="text-muted">Votes Today</h6>
                    </div>

                    <div class="col text-right align-self-center">
                        <div data-label="{{ $stats['votes_today']['rate'] }}%" class="css-bar m-b-0 css-bar-info css-bar-{{ $stats['votes_today']['floored_rate'] }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col p-r-0 align-self-center">
                        <h2 class="font-light m-b-0">{{ $stats['total_votes']['value'] }}</h2>
                        <h6 class="text-muted">Total Votes</h6>
                    </div>

                    <div class="col text-right align-self-center">
                        <div data-label="{{ $stats['total_votes']['rate'] }}%" class="css-bar m-b-0 css-bar-primary css-bar-{{ $stats['total_votes']['floored_rate'] }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col p-r-0 align-self-center">
                        <h2 class="font-light m-b-0">{{ $stats['voters_eligible']['value'] }}</h2>
                        <h6 class="text-muted">Voters Eligible</h6>
                    </div>

                    <div class="col text-right align-self-center pl-1">
                        <div data-label="{{ $stats['voters_eligible']['rate'] }}%" class="css-bar m-b-0 css-bar-success css-bar-{{ $stats['voters_eligible']['floored_rate'] }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col p-r-0 align-self-center">
                        <h2 class="font-light m-b-0">{{ $stats['voters_ineligible']['value'] }}</h2>
                        <h6 class="text-muted">Invalid Voters</h6>
                    </div>

                    <div class="col text-right align-self-center pl-1">
                        <div data-label="{{ $stats['voters_ineligible']['rate'] }}%" class="css-bar m-b-0 css-bar-danger css-bar-{{ $stats['voters_ineligible']['floored_rate'] }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <h4 class="card-title">Election Standing</h4>

                        <div class="ml-auto">
                            <button
                                type="button"
                                id="btn-export"
                                class="btn btn-info float-right"
                                data-toggle="modal"
                                data-target="#modal-export"
                                {{ now()->format('Y-m-d') < $election->end_date ? 'disabled' : '' }}
                            >
                                <i class="fas fa-copy"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive m-t-20">
                        <table class="table stylish-table">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th colspan="2">Candidate</th>
                                    <th>Votes</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($winners as $winner)
                                    <tr>
                                        <td>{{ $winner->position->name }}</td>
                                        <td>
                                            <span class="round">
                                                <img src="{{ avatar_thumbnail_path($winner->user) }}" alt="user" width="50">
                                            </span>
                                        </td>
                                        <td>
                                            <h6>{{ $winner->user->full_name_formal }}</h6>
                                            <small class="text-muted">
                                                {{ str_limit($winner->user->grade_level.' - '.$winner->user->section, 15) }}
                                            </small>
                                        </td>
                                        <td>
                                            <span>{{ $winner->votes }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4"></div>
    </div>
    <!-- Row -->
@endsection

@section('modals')
    <div id="modal-export" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('root.elections.results.export', $election) }}" class="form-material">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">
                            Export Results
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
                        <button type="submit" id="btn-modal-export" class="btn btn-info waves-effect">Export</button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/assets/plugins/chartist-js/dist/chartist.min.css">
    <link rel="stylesheet" href="/assets/plugins/chartist-js/dist/chartist-init.css">
    <link rel="stylesheet" href="/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css">
    <link rel="stylesheet" href="/assets/plugins/css-chart/css-chart.css">
@endsection

@section('scripts')
    <script src="/assets/plugins/chartist-js/dist/chartist.min.js"></script>
    <script src="/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
@endsection