@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Candidate Creation
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.candidates.index', $election) }}">
                Candidates
            </a>
        </li>

        <li class="breadcrumb-item active">
            Create
        </li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Nominate a Candidate to run in {{ $election->name }}
                    </h4>

                    <h6 class="card-subtitle">
                        Search the candidate here, please input their firstname and/or lastname.
                    </h6>

                    <form method="GET" action="" class="form-material" submit-once>
                        <input type="hidden" name="c" value="{{ Request::input('c') }}">

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
                                    <button type="submit" class="btn btn-info btn-loading">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <!--/. Submit -->
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row zoom-gallery">
                        @unless(count($users))
                            <div class="col-md p-5 text-center">
                                <span class="font-weight-normal">
                                    No results found,
                                    {{ empty(Request::input()) ? "Try searching for the student's name." : 'Try refining your search parameters.' }}
                                </span>
                            </div>
                        @else
                            @foreach ($users as $user)
                                <!-- user -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card candidate">
                                        <a class="candidate-image-link" href="{{ avatar_thumbnail_path($user) }}" title="{{ $user->full_name }}">
                                            <img class="card-img-top img-responsive magnifiable candidate-image" src="{{ avatar_thumbnail_path($user) }}" alt="">
                                        </a>

                                        <div class="card-body candidate-content">
                                            <h4 class="card-title candidate-name">
                                                {{ $user->full_name_formal }}
                                            </h4>

                                            <p class="card-text candidate-detail">
                                                <span class="font-weight-normal">
                                                    {{ optional($user->grade)->level.' - '.optional($user->section)->name }}
                                                </span>
                                            </p>

                                            <div class="candidate-footer">
                                                <button
                                                    type="button"
                                                    class="btn btn-success link-nominate"
                                                    data-toggle="modal"
                                                    data-target="#modal-nominate"
                                                    data-user-id={{ $user->id }}
                                                    data-user-name="{{ $user->full_name_formal }}"
                                                    data-user-grade="{{ optional($user->grade)->level }}"
                                                    data-user-section="{{ optional($user->section)->name }}"
                                                >
                                                    <i class="fas fa-ribbon"></i> Nominate
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/. user -->
                            @endforeach
                        @endunless
                    </div>

                    @unless(count($users) >= $allUserCount)
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group text-center">
                                    <a
                                        href="{{ Request::fullUrlWithQuery([
                                            'c' => (Request::input('c') ?? 8) + 8,
                                            'firstname' => Request::input('firstname'),
                                            'lastname' => Request::input('lastname')
                                        ]) }}"
                                        class="btn btn-secondary">Load More
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="modal-nominate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form
                    method="POST"
                    action="{{ route('root.elections.candidates.store', $election) }}"
                    class="form-material"
                    submit-once
                >
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
                                    <option value="{{ $position->id }}">
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!--/. Position -->

                        <!-- Party List -->
                        <div class="form-group">
                            <label for="partylist">Party List</label>
                        
                            <select name="partylist" id="partylist" class="form-control">
                                <option selected disabled>Please select a party list</option>
                        
                                    @foreach ($partylists as $partylist)
                                        <option value="{{ $partylist->id }}">
                                            {{ $partylist->name }}
                                        </option>
                                    @endforeach
                            </select>
                        </div>
                        <!--/. Party List -->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btn-modal-nominate" class="btn btn-info btn-loading waves-effect">
                            <i class="fas fa-ribbon"></i> Nominate
                        </button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .candidate-content {
            text-align: center;
            min-height: 200px;
        }

        .candidate-content .candidate-name {
            /* min-height: 75px; */
        }

        .candidate-content .candidate-detail {
            /* min-height: 25px; */
        }

        .candidate-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
        }
    </style>
@endsection

@section('scripts')
    <script src="/assets/plugins/datatables/datatables.min.js"></script>

    <script>
        $('#table-users').DataTable({
            "bLengthChange" : false,
        });

        $('.link-nominate').on('click', function(event) {
            var user = $(this).data('user-id');
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