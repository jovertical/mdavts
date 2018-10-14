@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Import Users
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.users.index') }}">Users</a>
        </li>

        <li class="breadcrumb-item active">
            Import
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Users Import
                    </h4>

                    <h6 class="card-subtitle">
                        Fields with
                        <span class="text-danger">*</span> are required
                    </h6>

                    <form
                        method="POST"
                        action="{{ route('root.users.import') }}"
                        class="form-material m-t-40"
                        enctype="multipart/form-data"
                        submit-once
                    >
                        @csrf

                        <!-- File -->
                        <div class="form-group">
                            <label>File</label>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>

                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Select file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="hidden">
                                    <input type="file" name="file">
                                </span>

                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>

                            <span class="help-block text-muted">
                                <small>
                                    File extensions supported:
                                    <code>csv</code>,
                                    <code>xlsx</code>,
                                    <code>xls</code>
                                </small>
                            </span>
                        </div>
                        <!--/. File -->

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-loading">
                                <i class="fas fa-upload"></i> Import
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

@section('scripts')
    <script src="/material/js/jasny-bootstrap.js"></script>
@endsection