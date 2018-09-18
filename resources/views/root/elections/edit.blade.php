@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Edit an election
        @endslot

        <li class="breadcrumb-item active">
            Edit
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
                        action="{{ route('root.elections.update', $election) }}"
                        class="form-material m-t-40"
                        submit-once
                    >
                        @csrf
                        @method('PATCH')

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
                                value="{{ old('name') ?? $election->name }}"
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
                            <label for="Name">
                                Start Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="start_date"
                                id="start_date"
                                class="form-control form-control-line"
                                value="{{ old('start_date') ?? $election->start_date }}"
                                placeholder="Start of Election"
                            >

                            <span class="help-block text-muted">
                                <small>
                                    Must be the date after or equal to <code>today</code>.
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
                            <label for="Name">
                                End Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="end_date"
                                id="end_date"
                                class="form-control form-control-line"
                                value="{{ old('end_date') ?? $election->end_date }}"
                                placeholder="End of Election"
                            >

                            <span class="help-block text-muted">
                                <small>
                                    Must be the date equal or after the <code>start date</code>.
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
                                {{ old('description') ?? $election->description }}
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
    <link href="/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="/assets/plugins/summernote/dist/summernote-bs4.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/assets/plugins/summernote/dist/summernote-bs4.min.js"></script>

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
