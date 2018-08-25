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
                <form method="POST" action="{{ route('root.auth.password.request') }}" class="form-horizontal form-material" id="loginform">
                    @csrf

                    <h3 class="box-title m-b-20">
                        Forgot Password
                    </h3>

                    <!-- Email -->
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">

                            @if ($errors->has('email'))
                                <span class="text-danger">
                                    {{$errors->first('email')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <!--/. Email -->

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
                                Send Link
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection