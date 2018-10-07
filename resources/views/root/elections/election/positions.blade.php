@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Positions
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Positions
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Set Positions in {{ $election->name }}
                    </h4>
                    <h6 class="card-subtitle">
                        Pick position(s) that will be available for candidates to run in {{ $election->name }}
                    </h6>

                    <form method="POST" action="" submit-once>
                        @csrf

                        <div class="form-group row p-t-20">
                            <div class="col-sm-4">
                                @foreach ($positions as $position)
                                    <div class="m-b-10">
                                        <label class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                name="positions[]"
                                                value="{{ $position->id }}"
                                                class="custom-control-input"
                                                {{ in_array($position->id, $position_ids) ? 'checked' : '' }}
                                            >
                                            <span class="custom-control-label">
                                                {{ $position->name }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fas fa-check"></i> Set &nbsp;&nbsp;
                            </button>

                            <a href="{{ route('root.elections.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                        <!--/. Submit -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection