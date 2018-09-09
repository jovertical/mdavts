@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Edit Grade Level
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.grades.index') }}">Grades</a>
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

                    <form
                        method="POST"
                        action="{{ route('root.grades.update', $grade) }}"
                        class="form-material m-t-40"
                        enctype="multipart/form-data"
                        submit-once
                    >
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <!-- Level -->
                            <label for="level">Grade Level</label>

                            <input
                                type="number"
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
                        <!--/. Level -->

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>

                            <textarea
                                name="description"
                                id="description"
                                class="form-control form-control-line summernote"
                            >
                                {{ old('description') ?? $grade->description  }}
                            </textarea>

                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    {{ $errors->first('description') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Description -->

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fa fa-edit"></i> Update
                            </button>

                            <a href="{{ route('root.grades.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="/assets/plugins/summernote/dist/summernote-bs4.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="/assets/plugins/summernote/dist/summernote-bs4.min.js"></script>

    <script>
        $('.summernote').summernote({
            height: 350,
            minHeight: null,
            maxHeight: null,
            focus: false
        });
    </script>
@endsection