@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Create an election
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.index') }}">Elections</a>
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
                    <h6 class="card-subtitle"></h6>

                    <form method="POST" action="{{ route('root.elections.store') }}" class="form-material m-t-40">
                        @csrf

                        <div class="form-group">
                            <!-- Name -->
                            <div class="col-md">
                                <label for="Name">Name</label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control form-control-line"
                                    value="{{ old('name') }}"
                                    placeholder="Enter election name"
                                >

                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                            <!--/. Name -->

                            <br/>

                            <!-- Description -->
                            <div class="col-md">
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

                            <br/>

                            <!-- Date of Start -->
                            <div class="col-md">
                                <label for="start_date">Start</label>

                                <input
                                    type="text"
                                    name="start_date"
                                    id="start_date"
                                    class="form-control form-control-line"
                                    value="{{ old('start_date') }}"
                                    placeholder="Start of Election"
                                >

                                @if ($errors->has('start_date'))
                                    <span class="text-danger">
                                        {{ $errors->first('start_date') }}
                                    </span>
                                @endif
                            </div>
                            <!--/. Date of Start -->
                        </div>

                        <!-- Date of End -->
                        <div class="col-md">
                            <label for="end_date">End</label>

                            <input
                                type="text"
                                name="end_date"
                                id="end_date"
                                class="form-control form-control-line"
                                value="{{ old('end_date') }}"
                                placeholder="End of Election"
                            >

                            @if ($errors->has('end_date'))
                                <span class="text-danger">
                                    {{ $errors->first('end_date') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Date of End -->

                        <br/>
                        <br/>

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fas fa-plus"></i> Create
                            </button>

                            <a href="{{ route('root.elections.index') }}" class="btn btn-secondary btn-loading">
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

    <script>
        $('#start_date').bootstrapMaterialDatePicker({time: false});
        $('#end_date').bootstrapMaterialDatePicker({time: false});

        $('.summernote').summernote({
            height: 350,
            minHeight: null,
            maxHeight: null,
            focus: false
        });
    </script>
@endsection