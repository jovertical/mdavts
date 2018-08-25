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
                <form method="POST" action="{{ route('root.auth.password.set', $token) }}" class="form-horizontal form-material" id="loginform">
                    @csrf

                    <h3 class="box-title m-b-20">Setup a password</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" placeholder="Password">

                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    {{$errors->first('password')}}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">
                                    {{$errors->first('password_confirmation')}}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">
                                Setup
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection