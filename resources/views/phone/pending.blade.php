@extends('app.layout')

@section('content')

@livewire('phone-table', ['status' => 'Pending'] )

@endsection