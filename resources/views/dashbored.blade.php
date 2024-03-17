@extends('layout')

@section('content')
@include('partials._header')
@include('partials._sidebar')
<main class="main" id="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"></a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    @yield('inner_content')
</main>
@include('partials._footer')
@yield('notification')
@endsection