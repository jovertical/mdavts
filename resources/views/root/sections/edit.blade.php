@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Update Section
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.sections.index') }}">Sections</a>
        </li>

        <li class="breadcrumb-item active">
            Update
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
                        action="{{ route('root.sections.update', $section) }}"
                        class="form-material m-t-40"
                        submit-once
                    >
                        @method('PATCH')
                        @csrf

                        <!-- Grade -->
                        <div class="form-group">
                            <label for="grade">Grade</label>

                            <select name="grade" id="grade" class="form-control">
                                @foreach ($grades as $grade)
                                    <option
                                        value="{{ $grade->uuid_text }}"
                                        {{ (old('grade') ?? $section->grade->uuid_text) == $grade->uuid_text ? 'selected' : '' }}
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
                            <label for="name">Name</label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-line"
                                value="{{ old('name') ?? $section->name }}"
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
                                {{ old('description') ?? $section->description }}
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
                        <!--/.Submit -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="/root/assets/plugins/summernote/dist/summernote-bs4.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="/root/assets/plugins/summernote/dist/summernote-bs4.min.js"></script>

    <script>
        $('.summernote').summernote({
            height: 350,
            minHeight: null,
            maxHeight: null,
            focus: false
        });
    </script>
@endsection