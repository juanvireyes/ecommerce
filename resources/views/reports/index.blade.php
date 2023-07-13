@extends('template')

@section('title', 'Reportes')

@section('content')
    <div class="container m-auto mt-4">
        <h1 class="text-red-700 text-2xl text-center underline underline-offset-1 uppercase font-bold">
            Reportes
        </h1>

        @include('reports.partials.nav')

        @yield('table')
    </div>
@endsection
