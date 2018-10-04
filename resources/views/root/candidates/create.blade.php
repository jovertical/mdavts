@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Create Election Candidates
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.candidates.index') }}">Candidates</a>
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
                    <h6 class="card-subtitle">
                        Fields with
                        <span class="text-danger">*</span> are required
                    </h6>

                    <form
                        method="POST"
                        action="{{ route('root.candidates.store') }}"
                        class="form-material m-t-40"
                        submit-once
                    >
                        @csrf

                        <input type="hidden" name="election">
                        <input type="hidden" name="user">

                        <!-- Election -->
                        <div class="m-b-20">
                            <label for="">
                                Election <span class="text-danger">*</span>
                            </label>

                            <div id="election-input">
                                <input type="text" class="form-control typeahead" placeholder="Start typing to find election...">
                            </div>

                            @if ($errors->has('election'))
                                <span class="text-danger">
                                    {{ $errors->first('election') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Election -->

                        <!-- User -->
                        <div class="m-b-20">
                            <label for="">
                                User <span class="text-danger">*</span>
                            </label>

                            <div id="user-input">
                                <input type="text" class="form-control typeahead" placeholder="Start typing to find user...">
                            </div>

                            @if ($errors->has('user'))
                                <span class="text-danger">
                                    {{ $errors->first('user') }}
                                </span>
                            @endif
                        </div>
                        <!--/. User -->

                        <!-- Position -->
                        <div class="form-group">
                            <label for="position">
                                Position <span class="text-danger">*</span>
                            </label>

                            <select name="position" id="position" class="form-control">
                                <option selected disabled>Please select a position</option>
                            </select>

                            @if ($errors->has('position'))
                                <span class="text-danger">
                                    {{ $errors->first('position') }}
                                </span>
                            @endif
                        <!--/ Position /-->                           

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-info loading">
                                <i class="fa fa-plus"></i> Create
                            </button>

                            <a href="{{ route('root.candidates.index') }}" class="btn btn-secondary">
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

@section('styles')
    <link href="/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="/assets/plugins/typeahead.js-master/dist/typehead-min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/assets/plugins/typeahead.js-master/dist/typeahead.bundle.min.js"></script>

    <script>
        var elections = JSON.parse('{!! $elections !!}');
        var users = JSON.parse('{!! $users !!}');
        var positions = JSON.parse('{!! $positions !!}');

        var electionNames = elections.map(function(election) {
            return election.name;
        });
        var electionUuids = elections.map(function(election) {
            return election.uuid;
        });

        var userFullNames = users.map(function(user) {
            return user.full_name;
        });
        var userUuids = users.map(function(user) {
            return user.uuid_text;
        });

        var elections = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: electionNames
        });

        var users = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: userFullNames
        });

        $('#election-input .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'elections',
            source: elections
        }).on('typeahead:selected', function (event, selection) {
            var index = electionNames.indexOf(selection);
            var electionUuid = electionUuids[index];
            var electionInput = $('input[name=election]');
            var electionPositions = positions[electionUuid];

            electionInput.val(electionUuid);

            $('#position').html('<option selected disabled>Please select a position</option>');

            $.each(electionPositions, function(index, position) {
                $('#position').append($('<option>', {
                    value: index,
                    text: position
                }));
            });
        });

        $('#user-input .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'users',
            source: users
        }).on('typeahead:selected', function (event, selection) {
            var index = userFullNames.indexOf(selection);

            $('input[name=user]').val(userUuids[index]);
        });
    </script>
@endsection