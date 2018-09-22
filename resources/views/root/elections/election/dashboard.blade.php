@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Dashboard
        @endslot

        <li class="breadcrumb-item active">
            Dashboard
        </li>

        @slot('action')
            <div id="time" class="float-right"></div>
        @endslot
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
                        <h4 class="card-title">Standings</h4>

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

                    <div class="m-t-20">
                        <table id="table-standings" class="table stylish-table" style="min-height: 200px;">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Candidate</th>
                                    <th>Votes</th>
                                </tr>
                            </thead>

                            <tbody>
                                @unless(count($winners) > 0)
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <span class="font-weight-normal">No Data Yet</span>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($winners as $winner)
                                        <tr>
                                            <td>{{ $winner->position->name }}</td>
                                            <td>
                                                <div>
                                                    <span class="round mr-2">
                                                        <img src="{{ avatar_thumbnail_path($winner->user) }}" alt="user" width="50">
                                                    </span>

                                                    <span class="font-weight-normal">
                                                        {{ $winner->user->full_name_formal }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span>{{ $winner->votes }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endunless
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tracking</h4>
                    <table class="table browser m-t-30 no-border">
                        <tbody>
                            <tr>
                                <td>
                                    Set at least one position ({{ $election->positions->count() }})
                                </td>
                                <td class="text-right">
                                    @unless($election->positions->count() > 0)
                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                    @else
                                        <i class="fas fa-check text-success"></i>
                                    @endunless
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Set at least one candidate ({{ $election->candidates->count() }})
                                </td>
                                <td class="text-right">
                                    @unless($election->candidates->count() > 0)
                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                    @else
                                        <i class="fas fa-check text-success"></i>
                                    @endunless
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    100% voter eligibility ({{ $stats['voters_eligible']['value'].' / '.$stats['all_voters']['value'] }})
                                </td>
                                <td class="text-right">
                                    @if($stats['all_voters']['value'] == 0)
                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                    @elseif($stats['voters_eligible']['value'] != $stats['all_voters']['value'])
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    @else
                                        <i class="fas fa-check text-success"></i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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

    <script>
        // Set of dates that serves as starting point of the countdown.
        var dates = {
            upcoming: "{{ \Carbon\Carbon::parse($election->start_date)->addSeconds(86399)->format('M d Y, H:i:s') }}",
            active: "{{ \Carbon\Carbon::parse($election->end_date)->addSeconds(86399)->format('M d Y, H:i:s') }}",
        }

        // Set the date we're counting down to
        var countDownDate = new Date(dates['{{ $election->status }}']).getTime();

        // Update the count down every 1 second
        var x = setInterval(function () {
            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance > 0) {
                // Display the result in the element with id="time"
                document.getElementById("time").innerHTML =
                    '<h4 class="text-{{ $election->status_class }}">'
                        + days + "d " + hours + "h " + minutes + "m " + seconds + "s " +
                    '</h4>';
            } else {
                // If the count down is finished, write some text
                clearInterval(x);
                document.getElementById("time").innerHTML =
                    '<h4 class="text-danger">CLOSED</h4>';
            }
        }, 1000);
    </script>
@endsection