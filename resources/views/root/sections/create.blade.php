@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Create Section
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.sections.index') }}">Sections</a>
        </li>

        <li class="breadcrumb-item active">
            Create
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Please fill up the form</h4>
                    <h6 class="card-subtitle">
                        Fields with
                        <span class="text-danger">*</span> are required
                    </h6>

                    <form
                        method="POST"
                        action="{{ route('root.sections.store') }}"
                        class="form-material m-t-40"
                        submit-once
                    >
                        @csrf

                        <!-- Grade -->
                        <div class="form-group">
                            <label for="grade">
                                Grade<span class="text-danger">*</span>
                            </label>

                            <select name="grade" id="grade" class="form-control">
                                <option selected disabled>Please select a grade</option>

                                @foreach ($grades as $grade)
                                    <option
                                        value="{{ $grade->id }}"
                                        {{ old('grade') == $grade->id ? 'selected' : '' }}
                                    >
                                        {{ $grade->level }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('grade'))
                                <span class="text-danger">
                                    {{ $errors->first('grade') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Grade -->

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">
                                Name <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-line"
                                value="{{ old('name') }}"
                                placeholder="Enter Name"
                            >

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Name -->

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>

                            <textarea
                                name="description"
                                id="description"
                                class="form-control form-control-line summernote"
                            >
                                {{ old('description') }}
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
                                <i class="fa fa-plus"></i> Create
                            </button>

                            <a href="{{ route('root.grades.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                        <!--/.Submit -->
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