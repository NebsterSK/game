@extends('layouts.app')

@section('content')
    <div class="container">
        <livewire:city city="{{ $city->id }}"/>
    </div>
@endsection