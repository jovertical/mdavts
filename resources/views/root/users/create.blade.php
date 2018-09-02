@extends('root.templates.master')
    @section('content')
        @component('root.components.breadcrumbs')

        @slot('page_title')
            Create Users
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.users.index') }}">Users</a>
        </li>

        <li class="breadcrumb-item active">
            Create
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"></h4>
                    <h6 class="card-subtitle"></h6>

                    <form method="POST" action="{{ route('root.users.store') }}" class="form-material m-t-40" enctype="multipart/form-data" submit-once>
                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <!-- First Name -->
                                <div class="col-md">
                                    <label for="firstname">First Name</label>

                                    <input
                                        type="text"
                                        name="firstname"
                                        id="firstname"
                                        class="form-control form-control-line"
                                        value="{{ old('firstname') }}"
                                        placeholder="Enter First Name"
                                    >

                                    @if ($errors->has('firstname'))
                                        <span class="text-danger">
                                            {{ $errors->first('firstname') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/.First Name -->

                                <!-- Middle Name -->
                                <div class="col-md">
                                    <label for="Middle_Name">Middle Name</label>

                                    <input
                                        type="text"
                                        name="middlename"
                                        id="middlename"
                                        class="form-control form-control-line"
                                        value="{{ old('middlename') }}"
                                        placeholder="Enter Middle Name"
                                    >

                                    @if ($errors->has('middlename'))
                                        <span class="text-danger">
                                            {{ $errors->first('middlename') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/.Middle Name -->

                                <!-- Last Name -->
                                <div class="col-md">
                                    <label for="Last_Name">Last Name</label>

                                    <input
                                        type="text"
                                        name="lastname"
                                        id="lastname"
                                        class="form-control form-control-line"
                                        value="{{ old('lastname') }}"
                                        placeholder="Enter Last Name"
                                    >

                                    @if ($errors->has('lastname'))
                                        <span class="text-danger">
                                            {{ $errors->first('lastname') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/.Last Name -->
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender">Gender</label>

                            <select name="gender" id="gender" class="form-control">
                                <option selected disabled>Please select a gender</option>
                                <option value="male" {{ old( 'gender')=='male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old( 'gender')=='female' ? 'selected' : '' }}>Female</option>
                            </select>

                            @if ($errors->has('gender'))
                                <span class="text-danger">
                                    {{ $errors->first('gender') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Gender -->

                        <!-- Grade Level -->
                        <div class="form-group">
                            <label for="grade_level">Grade Level</label>

                            <input
                                type="text"
                                name="grade_level"
                                id="grade_level"
                                class="form-control form-control-line"
                                value="{{ old('grade_level') }}"
                                placeholder="Enter Grade Level"
                            >

                            @if ($errors->has('grade_level'))
                                <span class="text-danger">
                                    {{ $errors->first('grade_level') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Grade Level -->

                        <!-- Section -->
                        <div class="form-group">
                            <label for="section">Section</label>

                            <input
                                type="text"
                                name="section"
                                id="section"
                                class="form-control form-control-line"
                                value="{{ old('section') }}"
                                placeholder="Enter section"
                            >

                            @if ($errors->has('section'))
                                <span class="text-danger">
                                    {{ $errors->first('section') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Section -->

                        <!-- LRN -->
                        <div class="form-group">
                            <label for="lrn">LRN</label>

                            <input type="text" name="lrn" id="lrn" class="form-control form-control-line" value="{{ old('lrn') }}"
                                placeholder="Enter LRN">

                            @if ($errors->has('lrn'))
                                <span class="text-danger">
                                    {{ $errors->first('lrn') }}
                                </span>
                            @endif
                        </div>
                        <!--/. LRN -->

                        <!-- Image -->
                        <div class="form-group">
                            <label>Image</label>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>

                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Select file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="hidden">
                                    <input type="file" name="image">
                                </span>

                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                        <!--/. Image -->

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fa fa-plus"></i> Create
                            </button>

                            <a href="{{ route('root.users.index') }}" class="btn btn-secondary">
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
@endsection

@section('scripts')
    <script src="/root/assets/plugins/moment/moment.js"></script>
    <script src="/root/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/root/material/js/jasny-bootstrap.js"></script>
@endsection
