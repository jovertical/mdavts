@extends('front.templates.master')

@section('content')
    <div class="wrapper-large">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">
                    Review
                </h4>

                <div class="mb-4"></div>

                <div class="table-responsive m-t-40">
                    <div>
                        <table id="table-review" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Candidate</th>
                                    <th>Party List</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($candidates as $candidate)
                                    <tr>
                                        <td>{{ str_limit(optional($candidate->position)->name, 15) }}</td>
                                        <td>{{ str_limit(optional($candidate->user)->full_name_formal, 25) }}</td>
                                        <td>{{ str_limit(optional($candidate->party_list)->name ?? 'Independent', 15) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex mt-5">
                    <!-- Links -->
                    <div class="form-group">
                        <a href="{{ route('front.voting.identity') }}" class="btn btn-secondary btn-loading float-left">
                            <i class="fas fa-redo"></i> Vote Again
                        </a>
                    </div>
                    <!--/. Links -->
                </div>
            </div>
        </div>
    </div>
@endsection