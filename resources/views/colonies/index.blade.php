@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My colonies</h1>

        @foreach($colonies as $colony)
            <p><a href="{{ route('colonies.show', ['colony' => $colony->id]) }}">{{ $colony->name }}</a> | turn: {{ $colony->turn }} | created at: {{ $colony->created_at->format('Y-m-d H:i') }}</p>
        @endforeach
    </div>
@endsection