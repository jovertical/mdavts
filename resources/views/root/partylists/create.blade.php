@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Create a party list
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.partylists.index') }}">Party Lists</a>
        </li>

        <li class="breadcrumb-item active">
            Create
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form
                        method="POST"
                        action="{{ route('root.partylists.store') }}"
                        class="form-material m-t-40"
                        submit-once
                    >
                        @csrf

                        <!-- Party List -->
                        <div class="form-group">
                            <label for="party">Party</label>

                            <input
                                type="text"
                                name="party"
                                id="party"
                                class="form-control form-control-line"
                                value="{{ old('party') }}"
                                placeholder="Enter name of the party list"
                            >

                            @if ($errors->has('party'))
                                <span class="text-danger">
                                    {{ $errors->first('party') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Party List -->

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                        
                            <textarea name="description" 
                            id="description" 
                            class="form-control form-control-line summernote">
                                                        
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