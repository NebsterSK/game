@extends('layouts.app')

@section('content')
    <div class="container">
        <livewire:game cityId="{{ $city->id }}"/>
    </div>
@endsection