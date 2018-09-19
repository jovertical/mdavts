@extends('root.templates.election')

@section('content')
    @component('root.components._election.breadcrumbs')
        @slot('page_title')
            Election Control Numbers
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.elections.dashboard', $election) }}">
                {{ $election->name }}
            </a>
        </li>

        <li class="breadcrumb-item active">
            Control-Numbers
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.elections.control-numbers.create', $election) }}">
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
                    <h4 class="card-title">Election Control Numbers</h4>
                    <h6 class="card-subtitle">
                        This is the list of control numbers (of voters) that can be used for this election.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-control_numbers" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Voter</th>
                                        <th>Number</th>
                                        <th>Used</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($control_numbers as $cn)
                                        <tr>
                                            <td>
                                                <a href="{{ route('root.users.edit', $cn->user) }}">
                                                    {!! $cn->user->full_name_formal ?? '<i>No Data</i>'  !!}
                                                </a>
                                            </td>
                                            <td>{!! $cn->number ?? '<i>No Data</i>'  !!}</td>
                                            <td>
                                                @unless ($cn->used)
                                                    <span class="label label-rounded label-danger">
                                                        No
                                                    </span>
                                                @else
                                                    <span class="label label-rounded label-success">
                                                        Yes
                                                    </span>
                                                @endunless
                                            </td>
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
        $('#table-control_numbers').DataTable({
            "bLengthChange" : false,
        });
    </script>
@endsection