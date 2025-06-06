@extends('layouts.app')

@section('content')
    <div class="container">
        <livewire:game :colony="$colony"/>
    </div>
@endsection