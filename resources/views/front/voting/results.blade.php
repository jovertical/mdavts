@extends('front.templates.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">
                        Results
                    </h4>

                    <div class="mb-4"></div>

                    <div class="table-responsive m-t-40">
                        <table id="table-results" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Candidate</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach(range(1, 5) as $fuck)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex mt-5">
                        <!-- Links -->
                        <div class="form-group">
                            <a href="{{ route('front.voting.identity') }}" class="btn btn-secondary float-left">
                                Vote Again
                            </a>
                        </div>
                        <!--/. Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection