@extends('template')

@section('title', 'User management')

@section('content')
    <div class="mx-auto mt-4 px-4 py-2">
        <h1 class="text-center text-red-500 text-2xl font-bold">Usuarios</h1>
    </div>

    @include('superadmin.components.search-form')

    @include('superadmin.components.users-table')

@endsection
