@extends('root.templates.master')
    @section('content')
        @component('root.components.breadcrumbs')

        @slot('page_title')
            Edit User
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.users.index') }}">Users</a>
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
                        action="{{ route('root.users.update', $user) }}"
                        class="form-material m-t-40"
                        enctype="multipart/form-data"
                        submit-once
                    >
                        @method('PATCH')
                        @csrf

                        <h3 class="box-title m-t-40">Personal</h3>
                        <hr>

                        <div class="row">
                            <!-- First Name -->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="firstname">
                                        First Name <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="firstname"
                                        id="firstname"
                                        class="form-control form-control-line"
                                        value="{{ old('firstname') ?? $user->firstname }}"
                                        placeholder="Enter First Name"
                                    >

                                    @if ($errors->has('firstname'))
                                        <span class="text-danger">
                                            {{ $errors->first('firstname') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--/.First Name -->

                            <!-- Middle Name -->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="middlename">Middle Name</label>

                                    <input
                                        type="text"
                                        name="middlename"
                                        id="middlename"
                                        class="form-control form-control-line"
                                        value="{{ old('middlename') ?? $user->middlename }}"
                                        placeholder="Enter Middle Name"
                                    >

                                    @if ($errors->has('middlename'))
                                        <span class="text-danger">
                                            {{ $errors->first('middlename') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--/.Middle Name -->

                            <!-- Last Name -->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="firstname">
                                        Last Name <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="lastname"
                                        id="lastname"
                                        class="form-control form-control-line"
                                        value="{{ old('lastname') ?? $user->lastname }}"
                                        placeholder="Enter Last Name"
                                    >

                                    @if ($errors->has('lastname'))
                                        <span class="text-danger">
                                            {{ $errors->first('lastname') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--/.Last Name -->
                        </div>

                        <!-- Birthdate -->
                        <div class="form-group">
                            <label for="firstname">
                                Birthdate
                            </label>

                            <input
                                type="text"
                                name="birthdate"
                                id="birthdate"
                                class="form-control form-control-line"
                                placeholder="Input Birthdate"
                                value="{{ old('birthdate') ?? $user->birthdate }}"
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
                                <option value="male" {{ (old( 'gender') ?? $user->gender)  =='male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ (old( 'gender') ?? $user->gender)  =='female' ? 'selected' : '' }}>Female</option>
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
                            <label for="firstname">
                                Address
                            </label>

                            <input
                                type="text"
                                name="address"
                                id="address"
                                class="form-control form-control-line"
                                placeholder="Enter Address"
                                value="{{ old('address') ?? $user->address  }}"
                            >

                            @if ($errors->has('address'))
                                <span class="text-danger">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Address -->

                        <!-- Contact Number -->
                        <div class="form-group">
                            <label for="firstname">
                                Contact Number
                            </label>

                            <input
                                type="text"
                                name="contact_number"
                                id="contact_number"
                                class="form-control form-control-line"
                                placeholder="Enter Contact Number"
                                value="{{ old('contact_number') ?? $user->contact_number }}"
                            >

                            @if ($errors->has('contact_number'))
                                <span class="text-danger">
                                    {{ $errors->first('contact_number') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Contact Number -->

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

                        <h3 class="box-title m-t-40">School</h3>
                        <hr>

                        <!-- Grade -->
                        <div class="form-group">
                            <label for="grade">
                                Grade <span class="text-danger">*</span>
                            </label>

                            <select name="grade" id="grade" class="form-control">
                                <option selected disabled>Please select a grade</option>

                                @foreach ($grades as $grade)
                                    <option
                                        value="{{ $grade->uuid_text }}"
                                        data-sections="{{ $grade->sections->pluck('uuid_text')->toJson() }}"
                                        data-section-names="{{ $grade->sections->pluck('name')->toJson() }}"
                                        {{ (old('grade') ?? $user->grade->uuid_text)  == $grade->uuid_text ? 'selected' : '' }}
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


                        <!-- Section -->
                        <div class="form-group">
                            <div class="form-group">
                                <label for="grade">
                                    Section <span class="text-danger">*</span>
                                </label>

                                <select name="section" id="section" class="form-control">
                                    <option selected disabled>Please select a section</option>
                                </select>

                                @if ($errors->has('section'))
                                    <span class="text-danger">
                                        {{ $errors->first('section') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!--/. Section -->

                        <!-- LRN -->
                        <div class="form-group">
                            <label for="lrn">LRN</label>

                            <input
                                type="text"
                                name="lrn"
                                id="lrn"
                                class="form-control form-control-line"
                                value="{{ old('lrn') ?? $user->lrn }}"
                                placeholder="Enter LRN"
                            >

                            @if ($errors->has('lrn'))
                                <span class="text-danger">
                                    {{ $errors->first('lrn') }}
                                </span>
                            @endif
                        </div>
                        <!--/. LRN -->

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fa fa-edit"></i> Update
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

    <script>
        var i = "{{ App\Section::decodeUuid($user->section_uuid) }}";

        $('#birthdate').bootstrapMaterialDatePicker({
            time: false,
            maxDate: moment().subtract(10, 'years')
        });

        var appendSections = function (sections, sectionNames) {
            $('#section').html('<option selected disabled>Please select a section</option>');

            $.each(sections, function(index, section) {
                var select = section ==
                    "{{ App\Section::decodeUuid($user->section_uuid) }}" ? true : false;

                $('#section').append($('<option>', {
                    value: section,
                    text: sectionNames[index],
                    selected: select
                }));
            });
        }

        var el = $('#grade option:selected');
        var sections = el.data('sections');
        var sectionNames = el.data('section-names');

        if (el.val().length > 0) {
            appendSections(sections, sectionNames);
        }

        $('#grade').on('change', function(event) {
            el = $('#grade option:selected');
            sections = el.data('sections');
            sectionNames = el.data('section-names');

            appendSections(sections, sectionNames);
        });
    </script>
@endsection
