@extends('root.templates.auth')

@section('content')
    <div class="login-box">
        <!-- Message -->
        @if ($message = Session::get('message'))
            @component('root.components.alert')
                @slot('type')
                    {{ $message['type'] }}
                @endslot

                @slot('title')
                    {{ $message['title'] }}
                @endslot

                {{ $message['content'] }}
            @endcomponent
        @endif

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('root.auth.password.reset', $token) }}" class="form-horizontal form-material" id="loginform">
                    @csrf

                    <h3 class="box-title m-b-20">
                        Reset Password
                    </h3>

                    <!-- Password -->
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Password"
                            >

                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    {{$errors->first('password')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <!--/. Password -->

                    <!-- Password Confirmation -->
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                placeholder="Password Confirmation"
                            >

                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    {{$errors->first('password_confirmation')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <!--/. Password Confirmation -->

                    <div class="form-group">
                        <div class="d-flex no-block align-items-center">
                            <div class="ml-auto">
                                <a href="{{ route('root.auth.signin') }}" class="text-muted">
                                    <i class="fa fa-lock m-r-5"></i> Signin using your account.
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">
                                Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection