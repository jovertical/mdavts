@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Candidates
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Candidates
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.elections.candidates.create', $election) }}">
                <input type="hidden" name="c" value="8">

                <button type="submit" class="btn btn-info float-right">
                    <i class="fas fa-plus"></i> Create
                </button>
            </form>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Election Candidates</h4>
                    <h6 class="card-subtitle">
                        This is the list of candidates for this election.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-candidates" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Position</th>
                                        <th>Grade</th>
                                        <th>Section</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($candidates as $candidate)
                                        <tr>
                                            <td>
                                                <a href="{{ route('root.users.edit', $candidate->user) }}">
                                                    {{ $candidate->user->full_name_formal }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('root.positions.edit', $candidate->position) }}">
                                                    {{ $candidate->position->name }}
                                                </a>
                                            </td>
                                            <td>{!! optional($candidate->user->grade)->level ?? '<i>No Data</i>' !!}</td>
                                            <td>{!! optional($candidate->user->section)->name ?? '<i>No Data</i>'  !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/assets/plugins/datatables/datatables.min.js"></script>

    <script>
        $('#table-candidates').DataTable({
            "bLengthChange" : false,
        });
    </script>
@endsection