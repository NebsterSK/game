@extends('layouts.app')

@section('content')
    <div class="container">
        <livewire:game :city="$city"/>
    </div>
@endsection