@extends('front.templates.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-10">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">
                        Voting: {{ $position->name }}
                    </h4>

                    <div class="mb-4"></div>

                    <div class="row justify-content-center">
                        @foreach ($candidates as $candidate)
                            <!-- user -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="{{ avatar_thumbnail_path($candidate->user) }}" alt="">
                                    <div class="card-body candidate {{ session()->get("voting.selected.{$position->uuid_text}") == $candidate->user->uuid_text ? 'selected-candidate' : '' }}">
                                        <h4 class="card-title">
                                            {{ $candidate->user->full_name_formal }}
                                        </h4>

                                        <p class="card-text">
                                            <span class="font-weight-normal">
                                                {{ $candidate->user->grade_level.' - '.$user->section }}
                                            </span>
                                        </p>

                                        <p class="card-text">
                                            <span class="font-weight-bold">
                                                {{ $candidate->user->lrn }}
                                            </span>
                                        </p>

                                        <div class="candidate-footer">
                                            <form method="POST" action="">
                                                @csrf

                                                <input type="hidden" name="user_uuid" value="{{ $candidate->user->uuid_text }}">
                                                <input type="hidden" name="position_uuid" value="{{ $position->uuid_text }}">

                                                <button type="submit" class="btn btn-success">
                                                    Vote
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
                                    class="btn btn-secondary float-left {{ Request::input('pi') == 0 ? 'disabled' : '' }}"
                                >
                                    Back
                                </a>

                                @if (Request::input('pi') < ($election->positions->count() - 1))
                                    <a
                                        href="?pi={{ Request::input('pi') }}&next"
                                        class="btn btn-success float-right {{ ! in_array($position->uuid_text, array_keys(session()->get('voting.selected') ?? [])) ? 'disabled' : '' }}"
                                    >
                                        Next
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('front.voting.store', [$election, $user]) }}">
                                        @csrf

                                        <button type="submit" class="btn btn-success float-right {{ ! in_array($position->uuid_text, array_keys(session()->get('voting.selected') ?? [])) ? 'disabled' : '' }}">
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
    </div>
@endsection

@section('styles')
    <style>
        .candidate {
            text-align: center;
            min-height: 200px;
        }

        .candidate-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
        }

        .selected-candidate {
            background-color: #00796B!important;
        }

        .selected-candidate > .card-title, .selected-candidate > .card-text {
            color: #fff!important;
        }

        .selected-candidate > form > .btn {
            display: none!important;
        }
    </style>
@endsection