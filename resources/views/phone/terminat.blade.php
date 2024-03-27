@extends('app.layout')

@section('content')

@livewire('phone-table', ['status' => 'Terminated'] )

@endsection