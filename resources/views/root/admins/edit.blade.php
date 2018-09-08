@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Edit an admin
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.admins.index') }}">Admins</a>
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
                    <h6 class="card-subtitle">
                        Fields with
                        <span class="text-danger">*</span> are required
                    </h6>

                    <form
                        method="POST"
                        action="{{ route('root.admins.update', $admin) }}"
                        class="form-material m-t-40"
                        enctype="multipart/form-data"
                        submit-once
                    >
                        @csrf
                        @method('PATCH')

                        <h3 class="box-title m-t-40">General</h3>
                        <hr>

                        <div class="form-group">
                            <div class="row">
                                <!-- Firstname -->
                                <div class="col-md">
                                    <label for="firstname">
                                        First Name <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="firstname"
                                        id="firstname"
                                        class="form-control form-control-line"
                                        value="{{ old('firstname') ?? $admin->firstname }}"
                                        placeholder="Enter First Name"
                                    >

                                    @if ($errors->has('firstname'))
                                        <span class="text-danger">
                                            {{ $errors->first('firstname') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/. Firstname -->

                                <!-- Middlename -->
                                <div class="col-md">
                                    <label for="middlename">Middle Name</label>

                                    <input
                                        type="text"
                                        name="middlename"
                                        id="middlename"
                                        class="form-control form-control-line"
                                        value="{{ old('middlename') ?? $admin->middlename }}"
                                        placeholder="Enter Middle Name"
                                    >

                                    @if ($errors->has('middlename'))
                                        <span class="text-danger">
                                            {{ $errors->first('middlename') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/. Middlename -->

                                <!-- Lastname -->
                                <div class="col-md">
                                    <label for="lastname">
                                        Last Name <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="lastname"
                                        id="lastname"
                                        class="form-control form-control-line"
                                        value="{{ old('lastname') ?? $admin->lastname }}"
                                        placeholder="Enter Last Name"
                                    >

                                    @if ($errors->has('lastname'))
                                        <span class="text-danger">
                                            {{ $errors->first('lastname') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/. Lastname -->
                            </div>
                        </div>

                        <!-- Birthdate -->
                        <div class="form-group">
                            <label for="birthdate">Birth Date</label>

                            <input
                                type="text"
                                name="birthdate"
                                id="birthdate"
                                class="form-control form-control-line"
                                value="{{ old('birthdate') ?? $admin->birthdate }}"
                                placeholder="Enter Birth Date"
                            >

                            @if ($errors->has('birthdate'))
                                <span class="text-danger">
                                    {{ $errors->first('birthdate') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Birthdate -->

                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender">Gender</label>

                            <select name="gender" id="gender" class="form-control">
                                <option selected disabled>Please select a gender</option>
                                <option value="male" {{  old('gender') ?? $admin->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{  old('gender') ?? $admin->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>

                            @if ($errors->has('gender'))
                                <span class="text-danger">
                                    {{ $errors->first('gender') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Gender -->

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address">Address</label>

                            <input
                                type="text"
                                name="address"
                                id="address"
                                class="form-control form-control-line"
                                value="{{ old('address') ?? $admin->address }}"
                                placeholder="Enter Address"
                            >

                            @if ($errors->has('address'))
                                <span class="text-danger">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Address -->

                        <h3 class="box-title m-t-40">Account</h3>
                        <hr>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">
                                Email <span class="text-danger">*</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control form-control-line"
                                value="{{ old('email') ?? $admin->email }}"
                                placeholder="Enter Email"
                            >

                            @if ($errors->has('email'))
                                <span class="text-danger">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Email -->

                        <!-- Username -->
                        <div class="form-group">
                            <label for="contact_number">Username</label>

                            <input
                                type="text"
                                name="username"
                                id="username"
                                class="form-control form-control-line"
                                value="{{ old('username') ?? $admin->username }}"
                                placeholder="Enter Contact Number"
                            >

                            <span class="help-block text-muted">
                                <small>
                                    An auto generated username will be created, if left blank.
                                </small>
                            </span>

                            @if ($errors->has('username'))
                                <span class="text-danger">
                                    {{ $errors->first('username') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Username -->

                        <!-- Contact number -->
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>

                            <input
                                type="number"
                                name="contact_number"
                                id="contact_number"
                                class="form-control form-control-line"
                                value="{{ old('contact_number') ?? $admin->contact_number }}"
                                placeholder="Enter Contact Number"
                            >

                            @if ($errors->has('contact_number'))
                                <span class="text-danger">
                                    {{ $errors->first('contact_number') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Contact number -->

                        <!-- Image -->
                        <div class="form-group">
                            <label>Image</label>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename">
                                        {{ old('filename') ?? $admin->filename }}
                                    </span>
                                </div>

                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Select file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="hidden">
                                    <input type="file" name="image">
                                </span>

                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>

                            <span class="help-block text-muted">
                                <small>
                                    File extensions supported:
                                    <code>jpg/jpeg</code>,
                                    <code>png</code>,
                                    <code>gif</code>
                                </small>
                            </span>
                        </div>
                        <!--/. Image -->

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fas fa-edit"></i> Update
                            </button>

                            <a href="{{ route('root.admins.index') }}" class="btn btn-secondary">
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

    <script>
        $('#birthdate').bootstrapMaterialDatePicker({
            time: false,
            maxDate: moment().subtract(10, 'years')
        });
    </script>
@endsection
