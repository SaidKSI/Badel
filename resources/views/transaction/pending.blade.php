@extends('app.layout')

@section('content')

@livewire('transaction-table', ['status' => 'Pending'])

@endsection