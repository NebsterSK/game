@extends('layouts.app')

@section('content')
    <div class="container">
        <livewire:city cityId="{{ $city->id }}"/>
    </div>
@endsection