@extends('front.templates.master')

@section('content')
    <div class="wrapper-large">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">
                    {{ $position->name }}
                </h2>

                <div class="mb-4"></div>

                <div class="row justify-content-center zoom-gallery">
                    @foreach ($candidates as $candidate)
                        <!-- user -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card candidate">
                                <a class="candidate-image-link" href="{{ avatar_thumbnail_path($candidate->user) }}" title="{{ $candidate->user->full_name }}">
                                    <img class="card-img-top img-responsive magnifiable candidate-image" src="{{ avatar_thumbnail_path($candidate->user) }}">
                                </a>

                                <div class="card-body candidate-content {{ session()->get("voting.selected.{$position->uuid_text}") == $candidate->user->uuid_text ? 'selected-candidate' : '' }}">
                                    <h4 class="card-title candidate-name">
                                        {{ str_limit($candidate->user->full_name_formal, 25) }}
                                    </h4>

                                    <p class="card-text candidate-detail">
                                        <span class="font-weight-normal">
                                            {{ str_limit(optional($candidate->user->grade)->level.' - '.optional($candidate->user->section)->name, 15) }}
                                        </span>
                                    </p>

                                    <div class="candidate-footer">
                                        <form
                                            method="POST"
                                            action=""
                                            submit-once
                                        >
                                            @csrf

                                            <input type="hidden" name="user_uuid" value="{{ $candidate->user->uuid_text }}">
                                            <input type="hidden" name="position_uuid" value="{{ $position->uuid_text }}">

                                            <button type="submit" class="btn btn-brand btn-loading">
                                                <i class="fas fa-thumbs-up"></i> Vote
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/. user -->
                    @endforeach
                </div>

                <!-- Links -->
                <div class="form-group row">
                    <div class="col text-left">
                        <a
                            href="?pi={{ Request::input('pi') }}&back"
                            class="btn btn-secondary btn-loading {{ Request::input('pi') == 0 ? 'disabled' : '' }}"
                        >
                            Back
                        </a>
                    </div>

                    <div class="col text-right">
                        @if (Request::input('pi') < ($positions->count() - 1))
                            <a
                                href="?pi={{ Request::input('pi') }}&next"
                                class="btn btn-success btn-loading {{ ! in_array($position->uuid_text, array_keys(session()->get('voting.selected') ?? [])) ? 'disabled' : '' }}"
                            >
                                Next
                            </a>
                        @else
                            <form
                                method="POST"
                                action="{{ route('front.voting.store', [$election, $user]) }}"
                                submit-once
                            >
                                @csrf

                                <button type="submit" class="btn btn-success btn-loading {{ ! in_array($position->uuid_text, array_keys(session()->get('voting.selected') ?? [])) ? 'disabled' : '' }}">
                                    Submit
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
                <!--/. Links -->
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .candidate-content {
            text-align: center;
            min-height: 200px;
        }

        .candidate-content .candidate-name {
            min-height: 75px;
        }

        .candidate-content .candidate-detail {
            min-height: 25px;
        }

        .candidate-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
        }

        .position-indicator {
            list-style-type: none;
        }

        .position-indicator li {
            display: inline;
        }

        .selected-candidate {
            background-color: #4E342E!important;
        }

        .selected-candidate > .card-title, .selected-candidate > .card-text {
            color: #fff!important;
        }

        .selected-candidate > .candidate-footer {
            display: none!important;
        }
    </style>
@endsection