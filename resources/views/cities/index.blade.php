@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My cities</h1>

        @foreach($cities as $city)
            <p><a href="{{ route('cities.show', ['city' => $city->id]) }}">{{ $city->name }}</a> | turn: {{ $city->turn }} | created at: {{ $city->created_at->format('Y-m-d H:i') }}</p>
        @endforeach
    </div>
@endsection