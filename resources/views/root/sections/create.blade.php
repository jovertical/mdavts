@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Create Section
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.sections.index') }}">Section</a>
        </li>

        <li class="breadcrumb-item active">
            Create
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Please fill up the form</h4>
                    <h6 class="card-subtitle"></h6>

                    <form method="POST" action="{{ route('root.sections.store') }}" class="form-material m-t-40" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                        <!-- Year Level -->
                        <div class="form-group">
                            <label for="year_level">Year Level</label>

                            <select name="year_level" id="year_level" class="form-control">
                                <option selected disabled>Please select year level</option>
                                <option value="7" {{ old('year_level') == '7' ? 'selected' : '' }}>7</option>
                            </select>

                            @if ($errors->has('year_level'))
                                <span class="text-danger">
                                    {{ $errors->first('year_level') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Year Level -->

                        <!-- Level -->
                            <label for="name">Section Name</label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-line"
                                value="{{ old('name') }}"
                                placeholder="Enter Section"
                            >

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Level -->

                                
                        <div class="form-group">
                        <!-- Description -->
                            <label for="description">Description</label>

                            <input
                                type="text"
                                name="description"
                                id="description"
                                class="form-control form-control-line"
                                value="{{ old('description') }}"
                                placeholder="Enter Description"
                            >

                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    {{ $errors->first('description') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Descrpition -->



                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info">
                                <i class="fa fa-plus"></i> Create
                            </button>

                            <a href="{{ route('root.grades.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                        <br/>
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
@endsection