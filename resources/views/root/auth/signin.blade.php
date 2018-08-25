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
                <form method="POST" action="{{ route('root.auth.signin') }}" class="form-horizontal form-material" id="loginform">
                    @csrf

                    <h3 class="box-title m-b-20 text-center">
                        Administrator Panel
                    </h3>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name = 'username' value="{{ old('username') }}" placeholder="Username or Email">

                            @if ($errors->has('username'))
                                <span class="text-danger">
                                    {{$errors->first('username')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name = 'password' placeholder="Password">

                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    {{$errors->first('password')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex no-block align-items-center">
                            <div class="checkbox checkbox-primary p-t-0">
                                <input name="remember" id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup">Remember me</label>
                            </div>

                            <div class="ml-auto">
                                <a href="{{ route('root.auth.password.request') }}" class="text-muted">
                                    <i class="fa fa-lock m-r-5"></i> Forgot password?
                                </a>
                            </div>
                        </div>

                        <div class="d-flex no-block align-items-center">
                            <div class="ml-auto">
                                <a href="{{ route('root.auth.verify.request') }}" class="text-muted">
                                    <i class="fa fa-lock m-r-5"></i> Verify account?
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">
                                Sign in
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection