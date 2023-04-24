@extends('template')

@section('title', 'Tienda')

@section('content')

    {{-- Categorías  --}}
    <div class="mx-auto mt-2 py-2">
        <h1 class="text-red-700 text-2xl text-center font-bold mx-auto mb-2">Categorías</h1>
    </div>
    <div class="container mx-auto mt-4 mb-3 px-3 flex gap-2">
        @yield('categories')
    </div>

    {{-- Productos --}}
    <div class="container mx-auto mt-2 mb-3">
        @yield('products')
    </div>
    
@endsection