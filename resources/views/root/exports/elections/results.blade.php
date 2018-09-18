@extends('root.templates.export')

@section('title')
    {{ $heading }}
@endsection

@section('content')
    <div class="heading">
        <h1 class="heading-text">{{ $heading }}</h1>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Position</th>
                <th>Candidate</th>
                <th>Votes</th>
            </tr>
        </thead>

        <tbody>
            @foreach($archives as $stats)
                <tr>
                    <td>{{ $stats->position->name }}</td>
                    <td>{{ $stats->user->full_name_formal }}</td>
                    <td>{{ $stats->votes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection