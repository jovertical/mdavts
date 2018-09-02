@extends('front.templates.master')

@section('content')
    <div class="wrapper-large">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">
                    {{ $position->name }}
                </h4>

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
                                            {{ $candidate->user->grade_level.' - '.$user->section }}
                                        </span>
                                    </p>

                                    <div class="candidate-footer">
                                        <form method="POST" action="">
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

                <div class="row">
                    <div class="col-md">
                        <!-- Links -->
                        <div class="form-group">
                            <a
                                href="?pi={{ Request::input('pi') }}&back"
                                class="btn btn-secondary btn-loading float-left {{ Request::input('pi') == 0 ? 'disabled' : '' }}"
                            >
                                Back
                            </a>

                            @if (Request::input('pi') < ($positions->count() - 1))
                                <a
                                    href="?pi={{ Request::input('pi') }}&next"
                                    class="btn btn-success btn-loading float-right {{ ! in_array($position->uuid_text, array_keys(session()->get('voting.selected') ?? [])) ? 'disabled' : '' }}"
                                >
                                    Next
                                </a>
                            @else
                                <form method="POST" action="{{ route('front.voting.store', [$election, $user]) }}">
                                    @csrf

                                    <button type="submit" class="btn btn-success btn-loading float-right {{ ! in_array($position->uuid_text, array_keys(session()->get('voting.selected') ?? [])) ? 'disabled' : '' }}">
                                        Submit
                                    </button>
                                </form>
                            @endif
                        </div>
                        <!--/. Links -->
                    </div>
                </div>
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