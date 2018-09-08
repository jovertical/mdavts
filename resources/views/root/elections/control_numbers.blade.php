@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Control Numbers
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.index') }}">Elections</a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.edit', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Control Numbers
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Control Numbers in {{ $election->name }}
                    </h4>
                    <h6 class="card-subtitle"></h6>

                    <form method="POST" action="" submit-once>
                        @csrf

                        <div class="form-group row p-t-20">
                            <div class="col-sm-4">
                                <ul class="list-icons">
                                    <li>
                                        Total users: {{ $data->all_users }}
                                    </li>
                                    <li>
                                        Users with control number: {{ $data->with }}
                                    </li>
                                    <li>
                                        Users without control number: {{ $data->without }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fas fa-plus"></i> Generate
                            </button>

                            <a href="{{ route('root.elections.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                        <!--/. Submit -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection