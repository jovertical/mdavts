@extends('root.templates.master') @section('content') @component('root.components.breadcrumbs') @slot('page_title') Create
Users @endslot

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

                <form method="POST" action="{{ route('root.users.store') }}" class="form-material m-t-40">
                    @csrf

                    <div class="form-group">
                        <!-- First Name -->
                        <div class="col-md">
                            <label for="First_Name">First Name</label>

                            <input type="text" name="firstname" id="firstname" class="form-control form-control-line" value="{{ old('firstname') }}"
                                placeholder="Enter First Name"> @if ($errors->has('first_name'))
                            <span class="text-danger">
                                {{ $errors->first('firstname') }}
                            </span>
                            @endif
                        </div>
                        <!--/.First Name -->

                        <br/>

                        <!-- Middle Name -->
                        <div class="col-md">
                            <label for="Middle_Name">Middle Name</label>

                            <input type="text" name="middlename" id="middlename" class="form-control form-control-line" value="{{ old('middlename') }}"
                                placeholder="Enter Middle Name"> @if ($errors->has('middlename'))
                            <span class="text-danger">
                                {{ $errors->first('middlename') }}
                            </span>
                            @endif
                        </div>
                        <!--/.Middle Name -->

                        <br/>

                        <!-- Last Name -->
                        <div class="col-md">
                            <label for="Last_Name">Last Name</label>

                            <input type="text" name="lastname" id="lastname" class="form-control form-control-line" value="{{ old('lastname') }}"
                                placeholder="Enter Last Name"> @if ($errors->has('lastname'))
                            <span class="text-danger">
                                {{ $errors->first('lastname') }}
                            </span>
                            @endif
                        </div>
                        <!--/.Last Name -->

                        <br/>

                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender">Gender</label>

                            <select name="gender" id="gender" class="form-control">
                                <option selected disabled>Please select a gender</option>
                                <option value="male" {{ old( 'gender')=='male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old( 'gender')=='female' ? 'selected' : '' }}>Female</option>
                            </select> @if ($errors->has('gender'))
                            <span class="text-danger">
                                {{ $errors->first('gender') }}
                            </span> @endif
                        </div>
                        <!--/. Gender -->

                        <br/>

                        <!-- Grade Level -->
                        <div class="col-md">
                            <label for="grade_level">Grade Level</label>

                            <input type="text" name="grade_level" id="grade_level" class="form-control form-control-line" value="{{ old('grade_level') }}"
                                placeholder="Enter Grade Level"> @if ($errors->has('grade_level'))
                            <span class="text-danger">
                                {{ $errors->first('grade_level') }}
                            </span> @endif
                        </div>
                        <!--/. Grade Level -->

                        <br/>

                        <!-- Section -->
                        <div class="col-md">
                            <label for="section">Section</label>

                            <input type="text" name="section" id="section" class="form-control form-control-line" 
                            value="{{ old('section') }}" 
                            placeholder="Enter section"> 
                            
                            @if ($errors->has('section'))
                            <span class="text-danger">
                                {{ $errors->first('section') }}
                            </span> @endif
                        </div>
                        <!--/. Section -->

                        <br/>

                       

                        <br/>

                        <!-- Learner's Reference Number -->
                        <div class="col-md">
                            <label for="lrn">Learner's Reference Number</label>

                            <input type="text" name="lrn" id="lrn" class="form-control form-control-line" value="{{ old('lrn') }}"
                                placeholder="Enter Learner's Reference Number"> @if ($errors->has('lrn'))
                            <span class="text-danger">
                                {{ $errors->first('lrn') }}
                            </span>
                            @endif
                        </div>
                        <!--/. Learner's Reference Number -->
                    </div>

                    <br/>
                    <br/>

                    <!-- Submit -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">
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
@endsection @section('styles')
<link href="/root/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet"> @endsection @section('scripts')
<script src="/root/assets/plugins/moment/moment.js"></script>
<script src="/root/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

@endsection
