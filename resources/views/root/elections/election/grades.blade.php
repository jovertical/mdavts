@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Grades
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Grades
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Set Grades in {{ $election->name }}
                    </h4>
                    <h6 class="card-subtitle">
                        Pick grade(s) that will be involved in {{ $election->name }}
                    </h6>

                    <form method="POST" action="" submit-once>
                        @csrf

                        <div class="form-group row p-t-20">
                            <div class="col-sm-4">
                                @foreach ($grades as $grade)
                                    <div class="m-b-10">
                                        <label class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                name="grades[]"
                                                value="{{ $grade->id }}"
                                                class="custom-control-input"
                                                {{ in_array($grade->id, $grade_ids) ? 'checked' : '' }}
                                            >
                                            <span class="custom-control-label">
                                                {{ $grade->level }}
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