@extends('layouts.app')

@section('content')
<div class="container">
    <p>dashboard</p>

    @foreach($cities as $city)
        <a href="{{ route('cities.show', ['city' => $city->id]) }}">{{ $city->name }}</a>
    @endforeach
</div>
@endsection
