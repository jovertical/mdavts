@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Edit grades level
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.grades.index') }}">Grades Levels</a>
        </li>

        <li class="breadcrumb-item active">
            Edit
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Please fill up the form</h4>
                    <h6 class="card-subtitle"></h6>

                    <form method="POST" action="{{ route('root.grades.update', $grade) }}" class="form-material m-t-40">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <!-- Name -->
                            <div class="col-md">
                                <label for="level">Year Level</label>

                                <input
                                    type="text"
                                    name="level"
                                    id="level"
                                    class="form-control form-control-line"
                                    value="{{ old('level') ?? $grade->level }}"
                                    placeholder="Enter Year Level"
                                >

                                @if ($errors->has('level'))
                                    <span class="text-danger">
                                        {{ $errors->first('level') }}
                                    </span>
                                @endif
                            </div>
                            <!--/. Name -->

                            <!-- Description -->
                            <div class="col-md">
                                <label for="description">Description</label>

                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control form-control-line summernote"
                                >{{ old('description') ?? $grade->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="text-danger">
                                        {{ $errors->first('description') }}
                                    </span>
                                @endif
                            </div>
                            <!--/. Description -->

                        <!-- Submit -->
                        <div class="col-md">
                            <button type="submit" class="btn btn-info">
                                <i class="fa fa-edit"></i> Update
                            </button>

                            <a href="{{ route('root.grades.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                        <!--/. Submit -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="/root/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="/root/assets/plugins/summernote/dist/summernote-bs4.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="/root/assets/plugins/moment/moment.js"></script>
    <script src="/root/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/root/assets/plugins/summernote/dist/summernote-bs4.min.js"></script>


@endsection
