@extends('front.templates.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
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
                            <!--/. user -->
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <!-- Submit -->
                            <div class="form-group">
                                <a
                                    href="?pi={{ Request::input('pi') }}&back"
                                    class="btn btn-secondary float-left {{ Request::input('pi') == 0 ? 'disabled' : '' }}"
                                >
                                    Back
                                </a>

                                <a
                                    href="?pi={{ Request::input('pi') }}&next"
                                    class="btn btn-success float-right {{  Request::input('pi') >= ($election->positions->count() - 1) ? 'disabled' : '' }}"
                                >
                                    Next
                                </a>
                            </div>
                            <!--/. Submit -->
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
            min-height: 175px;
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