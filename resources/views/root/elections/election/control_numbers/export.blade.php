@extends('root.templates.export')

@section('title')
    {{ $heading }}
@endsection

@section('content')
    <div class="heading-wrapper">
        <h1 class="heading">{{ $heading }}</h1>
        <p class="sub-heading">{{ $subHeading }}</p>
    </div>

    <div class="title-wrapper">
        <h1 class="title">{{ $title }}</h1>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Voter</th>
                <th>Grade</th>
                <th>Section</th>
                <th>Number</th>
                <th>Used</th>
            </tr>
        </thead>

        <tbody>
            @foreach($archives as $stats)
                <tr>
                    <td>{{ "{$stats->lastname}, {$stats->firstname} {$stats->middlename}" }}</td>
                    <td>{{ $stats->grade ?? '-' }}</td>
                    <td>{{ $stats->section ?? '-' }}</td>
                    <td>{{ $stats->number }}</td>
                    <td>{{ $stats->used ? 'Yes' : 'Not Yet' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection