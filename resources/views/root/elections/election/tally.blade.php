@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Tally
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Tally
        </li>

        @slot('action')
            <button
                type="button"
                id="btn-declare"
                class="btn btn-success float-right"
                data-toggle="modal"
                data-target="#modal-declare"
                {{ $election->status != 'ended' ? 'disabled' : '' }}
            >
                <i class="fas fa-balance-scale"></i> Declare
            </button>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Tally in {{ $election->name }}
                    </h4>
                    <h6 class="card-subtitle">
                        This is the list of tally grouped by position
                    </h6>

                    <form method="GET" action="" class="form-material" submit-once>
                        <div class="row">
                            <div class="col-md">
                                <!-- Position -->
                                <div class="form-group">
                                    <label for="position">Position</label>

                                    <select name="position" id="position" class="form-control">
                                        <option value="" {{ Request::input('position') == null ? 'selected disabled' : '' }}>All</option>

                                        @foreach ($election->positions as $position)
                                            <option
                                                value="{{ $position->id }}"
                                                {{ Request::input('position') == $position->id ? 'selected disabled' : '' }}
                                            >
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--/. Position -->
                            </div>
                        </div>

                        <div class="row">
                            <!-- Submit -->
                            <div class="col-md">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-loading">
                                        <i class="fa fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                            <!--/. Submit -->
                        </div>
                    </form>
                </div>
            </div>

            @foreach ($archives as $stats)
                <div class="card">
                    <div class="card-header">
                        Tally for {{ $stats['position']->name }}
                        <div class="card-actions">
                            <a class="" data-action="collapse">
                                <i class="ti-minus"></i>
                            </a>
                            <a class="btn-minimize" data-action="expand">
                                <i class="mdi mdi-arrow-expand"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body collapse show">
                        <div class="table-responsive m-t-40">
                            <div>
                                <table id="table-tally" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Candidate</th>
                                            <th>Vote Count</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach(collect($stats['votes'])->sortByDesc('votes') as $vote)
                                            <tr>
                                                <td>
                                                    @if (optional($vote->candidate->candidate)->winner)
                                                        <span class="text-warning">
                                                            <i class="fas fa-trophy"></i>
                                                        </span>
                                                    @endif
                                                    
                                                    <span class="ml-2">
                                                        {{ str_limit($vote->candidate->full_name_formal, 25) }}
                                                    </span>
                                                </td>
                                                <td>{{ $vote->votes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modals')
    <div id="modal-declare" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('root.elections.winners.declare', $election) }}" class="form-material">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">
                            Declare {{ $election->name }} Winners
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="modal-body">
                        <div id="tb-wrapper">
                            <div id="tb-header"></div>
                            <div id="tb-body" class="row justify-content-center"></div>
                            <div id="tb-footer">
                                <!-- Links -->
                                <div class="form-group row">
                                    <div class="col text-left">
                                        <button type="button" id="btn-tb-back" class="btn btn-secondary">
                                            Back
                                        </a>
                                    </div>

                                    <div class="col text-center">
                                        <button type="button" id="btn-tb-randomize" class="btn btn-warning btn-loading">
                                            Randomize
                                        </button>
                                    </div>
                
                                    <div class="col text-right">
                                        <button type="button" id="btn-tb-next" class="btn btn-secondary">
                                            Next
                                        </button>
                                    </div>
                                </div>
                                <!--/. Links -->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btn-modal-declare" class="btn btn-info waves-effect">
                            Declare
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .candidate {
            text-align: center;
            min-height: 250px;
        }

        .candidate-name {
            font-size: 1rem;
        }

        .selected-candidate {
            background-color: #4E342E!important;
        }

        .selected-candidate > .card-title, .selected-candidate > .card-text {
            color: #fff!important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        var tbIndex = 0;

        var fetchTieBreakers = function (tieBreaker) {
            $.ajax({
                type: 'GET',
                url: "{{ route('root.elections.ties.fetch', $election) }}"
            }).done(function (tieBreakers) {
                var candidates = tieBreakers[tieBreaker];

                if (candidates) {
                    // Clear our containment areas.
                    $('#tb-header').html('');
                    $('#tb-body').html('');

                    $('#tb-header').append(' \
                        <div class="mb-2"> \
                            <h2 class="card-title text-center">'
                                +candidates[tieBreaker].position.name+
                            '</h2> \
                            <h4 class="card-subtitle text-center"> \
                                Tied with <code> \
                                    '+candidates[tieBreaker].votes+' \
                                </code> votes each \
                            </h4> \
                        </div> \
                    ');
                
                    $.each(candidates, function (index, candidate) {
                        var user = candidate.candidate;
                        var fullName = user.lastname+', '+user.firstname+' '+user.middlename;
                        var trimmedFullName = fullName.length > 15 
                            ? fullName.substring(0, 15) + '...'
                            : fullName;
                        var hasWonIndicator = candidate.has_won ? 'selected-candidate' : '';

                        $('#tb-body').append(' \
                            <div class="col-4">\
                                <div class="card candidate">\
                                    <img \
                                        class="card-img-top img-responsive candidate-image" \
                                        src="'+ user.path +'" \
                                        onerror=this.src="/app/images/avatar.png" \
                                        alt="" \
                                    >\
                                    <div \
                                        class="card-body candidate-content '+hasWonIndicator+'" \
                                        data-key="'+user.id+'" \
                                    >\
                                        <h4 class="card-title candidate-name">\
                                            '+trimmedFullName+' \
                                        </h4> \
                                        <p class="card-text candidate-detail">\
                                            <span class="font-weight-normal">\
                                            </span>\
                                        </p>\
                                    </div>\
                                </div>\
                            </div>\
                        ');
                    });

                    // disable navigation buttons.
                    $('#btn-tb-back').attr({disabled: tbIndex == 0});
                    $('#btn-tb-next').attr({disabled: (tbIndex + 1) == candidates.length});

                    // disable randomize button
                    $('#btn-tb-randomize').attr({
                        disabled: candidates.filter(function (candidate) {
                            return candidate.has_won;
                        }).length > 0
                    });

                    // disable declare button if there's still position without a winner.
                    $('#btn-modal-declare').attr({
                        disabled: tieBreakers.filter(function (candidates) {
                            return candidates.filter(function (candidate) {
                                return candidate.has_won;
                            }).length > 0;
                        }).length != tieBreakers.length
                    }); 
                }                 
           });
        };

        var randomizeTies = function () {
            $.ajax({
                type: 'POST',
                url: "{{ route('root.elections.ties.randomize', $election) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    index: tbIndex
                }
            }).done(function(user) {
                // remove the loading animation.
                $('#btn-tb-randomize.btn-loading > i').remove();

                // disable the button.
                $('#btn-tb-randomize').attr({disabled: true});
                
                // indicator for the winner.
                $('.candidate-content').removeClass('selected-candidate');
                $('.candidate-content[data-key='+user.id+']').addClass('selected-candidate');
            
                // refetch tieBreakers.
                fetchTieBreakers(tbIndex);
            });
        }

        $('#btn-tb-back').on('click', function(event) {
            tbIndex -= 1;
        });

        $('#btn-tb-next').on('click', function(event) {
            tbIndex += 1;
        });

        $('#btn-tb-back, #btn-tb-next').on('click', function (event) {
            fetchTieBreakers(tbIndex);
        });

        $('#btn-tb-randomize').on('click', function (event) {
            randomizeTies();
        });

        $(document).ready(function(event) {
            fetchTieBreakers(tbIndex);
        });
    </script>
@endsection