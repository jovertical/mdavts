@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Edit a position
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.partylists.index') }}">Party Lists</a>
        </li>

        <li class="breadcrumb-item active">
            Edit
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">---</h4>
                    <h6 class="card-subtitle"></h6>

                    <form
                        method="POST"
                        action="{{ route('root.partylists.update', $partylists) }}"
                        class="form-material m-t-40"
                        submit-once
                    >
                        @method('PATCH')
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Party</label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-line"
                                value="{{ old('name') ?? $partylist->name }}"
                                placeholder="Enter name"
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
                                row="3"
                            >
                                {{ old('description') ?? $partylist->description }}
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
                                <i class="fas fa-edit"></i> Update
                            </button>

                            <a href="{{ route('root.partylists.index') }}" class="btn btn-secondary">
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