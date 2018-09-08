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
                    <h6 class="card-subtitle">
                        Fields with
                        <span class="text-danger">*</span> are required
                    </h6>

                    <form
                        method="POST"
                        action="{{ route('root.elections.store') }}"
                        class="form-material m-t-40"
                        submit-once
                    >
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="Name">
                                Name <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-line"
                                value="{{ old('name') }}"
                                placeholder="E.g. Election {{ date('Y') }}"
                            >

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Name -->

                        <!-- Date of Start -->
                        <div class="form-group">
                            <label for="start_date">
                                Start Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="start_date"
                                id="start_date"
                                class="form-control form-control-line"
                                value="{{ old('start_date') }}"
                                placeholder="Start of Election"
                            >

                            <span class="help-block text-muted">
                                <small>
                                    It must be after the <code>today</code>.
                                </small>
                            </span>

                            <br />

                            @if ($errors->has('start_date'))
                                <span class="text-danger">
                                    {{ $errors->first('start_date') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Date of Start -->

                        <!-- Date of End -->
                        <div class="form-group">
                            <label for="end_date">
                                End Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="end_date"
                                id="end_date"
                                class="form-control form-control-line"
                                value="{{ old('end_date') }}"
                                placeholder="End of Election"
                            >

                            <span class="help-block text-muted">
                                <small>
                                    It must be after <code>start date</code>.
                                </small>
                            </span>

                            <br />

                            @if ($errors->has('end_date'))
                                <span class="text-danger">
                                    {{ $errors->first('end_date') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Date of End -->

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
                                <i class="fas fa-plus"></i> Create
                            </button>

                            <a href="{{ route('root.elections.index') }}" class="btn btn-secondary">
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