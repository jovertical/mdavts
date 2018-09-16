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
                        <h2 class="font-light m-b-0">{{ $data['votes_today']['value'] }}</h2>
                        <h6 class="text-muted">Votes Today</h6>
                    </div>

                    <div class="col text-right align-self-center">
                        <div data-label="{{ $data['votes_today']['rate'] }}%" class="css-bar m-b-0 css-bar-info css-bar-{{ $data['votes_today']['floored_rate'] }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col p-r-0 align-self-center">
                        <h2 class="font-light m-b-0">{{ $data['total_votes']['value'] }}</h2>
                        <h6 class="text-muted">Total Votes</h6>
                    </div>

                    <div class="col text-right align-self-center">
                        <div data-label="{{ $data['total_votes']['rate'] }}%" class="css-bar m-b-0 css-bar-primary css-bar-{{ $data['total_votes']['floored_rate'] }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col p-r-0 align-self-center">
                        <h2 class="font-light m-b-0">{{ $data['voters_eligible']['value'] }}</h2>
                        <h6 class="text-muted">Voters Eligible</h6>
                    </div>

                    <div class="col text-right align-self-center pl-1">
                        <div data-label="{{ $data['voters_eligible']['rate'] }}%" class="css-bar m-b-0 css-bar-success css-bar-{{ $data['voters_eligible']['floored_rate'] }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col p-r-0 align-self-center">
                        <h2 class="font-light m-b-0">{{ $data['voters_ineligible']['value'] }}</h2>
                        <h6 class="text-muted">Invalid Voters</h6>
                    </div>

                    <div class="col text-right align-self-center pl-1">
                        <div data-label="{{ $data['voters_ineligible']['rate'] }}%" class="css-bar m-b-0 css-bar-danger css-bar-{{ $data['voters_ineligible']['floored_rate'] }}"></div>
                    </div>
                </div>
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