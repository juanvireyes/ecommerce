@extends('template')

@section('title', 'User Dashboard')

@section('content')
    @auth
        <div class="container mx-auto px-6 py-4 items-center">
            <h1 class="text-center text-red-600 text-2xl font-bold mb-6">Bienvenido {{ $user->name }}</h1>

            @if (Auth::user()->hasRole('superadmin'))
                <div class="flex justify-center text-center">
                    <div class="flex-5 mx-2">
                        <a href="{{ route('superadmin.index') }}">
                            <img src="{{ asset('images/group.png') }}" class="h-12 mx-auto mb-6">
                        </a>
                        <a href="{{ route('superadmin.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gestión de usuarios</a>
                    </div>
                    <div class="flex-5 mx-2">
                        <a href="{{ route('categories.index') }}">
                            <img src="{{ asset('images/categorias.png') }}" class="h-12 mx-auto mb-6">
                        </a>
                        <a href="{{ route('categories.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Gestión de categorías
                        </a>
                    </div>
                    <div class="flex-5 mx-2">
                        <a href="#">
                            <img src="{{ asset('images/products.png') }}" class="h-12 mx-auto mb-6">
                        </a>
                        <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gestión
                            de productos</a>
                    </div>
                </div>
            @elseif (Auth::user()->hasRole('admin'))
                <div class="flex justify-center text-center">
                    <div class="flex-5 mx-2">
                        <a href="{{ route('categories.index') }}">
                            <img src="{{ asset('images/categorias.png') }}" class="h-12 mx-auto mb-6">
                        </a>
                        <a href="{{ route('categories.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Gestión de categorías
                        </a>
                    </div>
                    <div class="flex-5 mx-2">
                        <a href="#">
                            <img src="{{ asset('images/products.png') }}" class="h-12 mx-auto mb-6">
                        </a>
                        <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gestión
                            de productos</a>
                    </div>
                </div>
            @else
                <div class="flex justify-center text-center">
                    <div class="flex-5 mx-2">
                        <a href="{{ route('clients.index') }}" class="mb-3">
                            <img src="{{ asset('images/products.png') }}" class="h-12 mx-auto mb-6">
                        </a>
                        <a href="{{ route('clients.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3">Ver
                            productos</a>
                    </div>
                    <div class="flex-5 mx-2">
                        <a href="{{ route('orders.index') }}" class="mb-3">
                            <img src="{{ asset('images/orders.png') }}" class="h-12 mx-auto mb-6">
                        </a>
                        <a href="{{ route('orders.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3">
                            Ver
                            órdenes
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endauth
@endsection
