@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Create a position
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.positions.index') }}">Positions</a>
        </li>

        <li class="breadcrumb-item active">
            Create
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">---</h4>
                    <h6 class="card-subtitle"></h6>

                    <form method="POST" action="{{ route('root.positions.store') }}" class="form-material m-t-40">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name</label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-line"
                                value="{{ old('name') }}"
                                placeholder="Enter name"
                            >

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Name -->
                        <!-- Name -->
                        <div class="form-group">
                                <label for="name">Level</label>

                                <input
                                    type="text"
                                    name="level"
                                    id="level"
                                    class="form-control form-control-line"
                                    value="{{ old('level') }}"
                                    placeholder="Enter level"
                                >

                                @if ($errors->has('level'))
                                    <span class="text-danger">
                                        {{ $errors->first('level') }}
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
                                row="3"
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
                                <i class="fas fa-plus"></i> Create
                            </button>

                            <a href="{{ route('root.positions.index') }}" class="btn btn-secondary btn-loading">
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