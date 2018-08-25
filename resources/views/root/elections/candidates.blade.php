@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Set Candidate
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
            Candidates
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Add a Candidate in {{ $election->name }}
                    </h4>

                    <h6 class="card-subtitle">
                        Search the candidate here, please input their firstname and/or lastname.
                    </h6>

                    <form method="GET" action="" class="form-material">
                        <div class="row">
                            <!-- Firstname -->
                            <div class="col-md">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="firstname"
                                        id="firstname"
                                        class="form-control form-control-line"
                                        value="{{ Request::input('firstname') }}"
                                        placeholder="Enter firstname"
                                    >

                                    @if ($errors->has('firstname'))
                                        <span class="text-danger">
                                            {{ $errors->first('firstname') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--/. Firstname -->

                            <!-- Lastname -->
                            <div class="col-md">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="lastname"
                                        id="lastname"
                                        class="form-control form-control-line"
                                        value="{{ Request::input('lastname') }}"
                                        placeholder="Enter lastname"
                                    >

                                    @if ($errors->has('lastname'))
                                        <span class="text-danger">
                                            {{ $errors->first('lastname') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--/. Lastname -->
                        </div>

                        <div class="row">
                            <!-- Submit -->
                            <div class="col-md">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <!--/. Submit -->
                        </div>
                    </form>

                    <div class="row">
                        @foreach ($users as $user)
                            <!-- user -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="{{ avatar_thumbnail_path($user) }}" alt="">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">
                                            {{ $user->full_name_formal }}
                                        </h4>

                                        <p class="card-text">
                                            <span class="font-weight-normal">
                                                {{ $user->grade_level.' - '.$user->section }}
                                            </span>
                                        </p>

                                        <p class="card-text">
                                            <span class="font-weight-bold">
                                                {{ $user->lrn }}
                                            </span>
                                        </p>

                                        <a
                                            href="#"
                                            class="btn btn-success link-nominate"
                                            data-toggle="modal"
                                            data-target="#modal-nominate"
                                            data-user-uuid={{ $user->uuid_text }}
                                            data-user-name="{{ $user->full_name_formal }}"
                                            data-user-grade="{{ $user->grade_level }}"
                                            data-user-section="{{ $user->section }}"
                                        >
                                            Nominate
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/. user -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="modal-nominate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="" class="form-material">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-nominate-title"></h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="user" id="user">

                        <!-- Position -->
                        <div class="form-group">
                            <label for="position">Position</label>

                            <select name="position" id="position" class="form-control">
                                <option selected disabled>Please select a position</option>

                                @foreach ($election->positions as $position)
                                    <option value="{{ $position->uuid_text }}">
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!--/. Position -->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btn-modal-nominate" class="btn btn-info waves-effect">Nominate</button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/root/assets/plugins/datatables/datatables.min.js"></script>

    <script>
        $('#table-users').DataTable({
            "bLengthChange" : false,
        });

        $('.link-nominate').on('click', function(event) {
            var user = $(this).data('user-uuid');
            var name = $(this).data('user-name');
            var name_text = '<span class="font-weight-bold">'+name+'</span>';
            var grade = $(this).data('user-grade');
            var section = $(this).data('user-section');
            var grade_section_text = '<span class="font-weight-bold">'
                +grade+' - '+section+
            '</span>';

            var title = 'Nominating '+name_text+' of ' + grade_section_text;

            $('input[name=user]').val(user);
            $('#modal-nominate-title').html(title);
        });
    </script>
@endsection