@if (Auth::user()->hasRole(['admin', 'superadmin']))

@extends('template')

@section('title', 'Subcategorías')

@section('content')
    <div class="container mx-auto my-auto py-4">
        <nav class="flex justify-center py-4">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:underline underline-offset-8 font-bold">Categorías</a>
            <a href="{{ route('subcategories.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:underline underline-offset-8 font-bold">Subcategorías</a>
            <a href="#" class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:underline underline-offset-8 font-bold">Productos</a>
        </nav>
    </div>

    <div class="container mx-auto">
        <div class="text-center mt-3 mb-3">
            <h1 class="text-red-600 text-2xl font-bold">Edición y creación de Subcategorías</h1>
        </div>

        <div class="text-right mx-6 mb-4 pb-4">
            <a href="{{ route('subcategories.create') }}" 
            class="bg-red-400 px-5 py-3 rounded-md drop-shadow-xl text-white font-semibold">
            Crear subcategoría
            </a>
        </div>

        <div class="mx-auto mt-6 px-4">
            <h1>Tabla subcategorías</h1>
        </div>
    </div>
@endsection

@endif