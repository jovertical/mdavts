@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            System Settings
        @endslot

        <li class="breadcrumb-item active">
            Settings
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">System-wide Settings</h4>
                    <h6 class="card-subtitle">Modify with caution</h6>

                    <form
                        method="POST"
                        action=""
                        class="form-material form-horizontal form-bordered m-t-40"
                        submit-once
                    >
                        @csrf

                        <h3 class="box-title m-t-40">Election</h3>
                        <hr>

                        <!-- Auto Update -->
                        <div class="form-group row">
                            <label class="control-label text-right col-md-3">Auto Update </label>

                            <div class="col-md-9">
                                <div class="switch my-2">
                                    <label>
                                        <input type="hidden" name="elec_auto_update" value="0">
                                        <input
                                            type="checkbox"
                                            name="elec_auto_update"
                                            {{ $settings['elec_auto_update'] ? 'checked' : '' }}
                                            value="1"
                                        >
                                        <span class="lever"></span>
                                    </label>
                                </div>

                                <span class="help-block text-muted">
                                    <small>
                                        Run a background process to <code>auto-update</code> election's status.
                                    </small>
                                </span>
                            </div>
                        </div>
                        <!--/. Auto Update -->

                        <!-- Submit -->
                        <div class="form-group row">
                            <div class="col-md-9 ml-auto">
                                <button type="submit" class="btn btn-info btn-loading">
                                    <i class="fas fa-edit"></i> Update
                                </button>

                                <a href="{{ route('root.dashboard') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                        <!--/. Submit -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection