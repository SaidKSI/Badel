@extends('app.layout')

@section('content')


@livewire('transaction-table', ['status' => 'Pending'])
@livewire('transaction-table', ['status' => 'Terminated'])


@endsection