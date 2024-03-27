@extends('app.layout')

@section('content')

@livewire('phone-table', ['status' => 'Canceled'] )

@endsection