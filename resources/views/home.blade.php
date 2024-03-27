@extends('app.layout')

@section('content')


@livewire('transaction-table', ['status' => 'Pending'] )
@livewire('transaction-table', ['status' => 'Accepted'])
@livewire('transaction-table', ['status' => 'Terminated'])
@livewire('transaction-table', ['status' => 'OnHold'])
@livewire('transaction-table', ['status' => 'Canceled'])


@endsection