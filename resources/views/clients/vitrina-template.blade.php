@extends('template')

@section('title', 'Tienda')

@section('content')

    {{-- Categorías  --}}
    <div class="container mx-auto mt-4 mb-3">
        @yield('categories')
    </div>

    {{-- Productos --}}
    <div class="container mx-auto mt-2 mb-3">
        @yield('products')
    </div>
    
@endsection