@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Edit profile
        @endslot

        <li class="breadcrumb-item active">
            Profile
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Please fill up the form</h4>
                    <h6 class="card-subtitle"></h6>

                    <form method="POST" action="{{ route('root.account.password') }}" class="form-material m-t-40">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                           
                                <!-- Firstname -->
                                <div class="col-md">
                                    <label for="old_password">Old Password</label>

                                    <input
                                        type="password"
                                        name="old_password"
                                        id="old_password"
                                        class="form-control form-control-line"
                                        placeholder="Enter old password"
                                    >

                                    @if ($errors->has('old_password'))
                                        <span class="text-danger">
                                            {{ $errors->first('old_password') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/. Firstname -->
                                <br/>
                                <!-- Firstname -->
                                <div class="col-md">
                                    <label for="password">New Password</label>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control form-control-line"
                                        placeholder="Enter new password"
                                    >

                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/. Firstname -->
                                <br/>
                                 <!-- Firstname -->
                                <div class="col-md">
                                    <label for="password_confirmation">Retype New Password</label>

                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control form-control-line"
                                        placeholder="Retype New Password"
                                    >

                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">
                                            {{ $errors->first('password_confirmation') }}
                                        </span>
                                    @endif
                                </div>
                                <!--/. Firstname -->

                        <br/>
                        <!-- Submit -->
                        <div class="col-md">
                            <button type="submit" class="btn btn-info">
                                <i class="fa fa-edit"></i> Update
                            </button>

                            <a href="{{ route('root.dashboard') }}" class="btn btn-secondary">
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

    <script>
        $('#birthdate').bootstrapMaterialDatePicker({time: false});
    </script>
@endsection