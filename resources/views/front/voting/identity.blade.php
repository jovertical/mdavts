@extends('front.templates.master')

@section('content')
    <div class="wrapper-small">
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
                <form method="POST" action="{{ route('front.voting.identity') }}" class="form-horizontal form-material" id="loginform">
                    @csrf

                    <h3 class="box-title m-b-40 text-center">
                        Voter Identification
                    </h3>

                    <div class="form-group">
                        <input type="text" name="control_number" class="form-control" value="{{ old('control_number') }}" placeholder="Enter Control Number">

                        @if ($errors->has('control_number'))
                            <span class="text-danger">
                                {{$errors->first('control_number')}}
                            </span>
                        @endif
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-success btn-loading btn-lg btn-block text-uppercase waves-effect waves-light">
                                Vote
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection