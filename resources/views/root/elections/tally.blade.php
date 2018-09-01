@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Tally
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
            Tally
        </li>
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

                    <form method="GET" action="" class="form-material">
                        <div class="row">
                            <div class="col-md">
                                <!-- Position -->
                                <div class="form-group">
                                    <label for="position">Position</label>

                                    <select name="position" id="position" class="form-control">
                                        <option value="" {{ Request::input('position') == null ? 'selected disabled' : '' }}>All</option>

                                        @foreach ($election->positions as $position)
                                            <option
                                                value="{{ $position->uuid_text }}"
                                                {{ Request::input('position') == $position->uuid_text ? 'selected disabled' : '' }}
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
                                                <td>{{ $vote->user->full_name }}</td>
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