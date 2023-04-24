@extends('template')

@section('title', 'Crear categoría')

@section('content')
    @if (Auth::user()->hasRole(['admin', 'superadmin']))
        <div class="container mx-auto px-4 py-4 text-center">
            <h1 class="text-red-500 text-2xl font-bold">Crear categoría</h1>
            
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" class="py-3">
            @csrf

                {{-- Nombre categoría --}}
                <div class="mt-3 mb-3">
                    <label for="name">
                        <input type="text" name="name" id="name" placeholder="Nombre Categoría" 
                        class="w-1/2 text-red-500 font-bold" 
                        value="{{ old('name') }}"
                        required 
                        autofocus 
                        autocomplete="name">
                    </label>
                </div>
                <div class="mt-2 text-red-700 text-lg font-bold text-center">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="mt-3 mb-3">
                    <label for="description">
                        <textarea name="description" id="description" placeholder="Descripción categoría"
                        class="w-1/2"
                        autocomplete="description"></textarea>
                    </label>
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Order--}}
                <div class="mt-3 mb-3">
                    <label for="order" class="text-red-500 text-medium font-bold mx-auto mr-2"> Orden en el display: </label>
                    <input type="number" 
                    name="order" 
                    id="order"
                    min="0" 
                    class="w-1/4 text-red-500 font-bold mx-auto" 
                    required>
                </div>
                <div>
                    @error('order')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Imagen --}}
                <div class="mt-3 mb-3">
                    <label for="file" 
                    class="text-red-500 text-medium font-bold"> 
                    Selecciona una imagen para la categoría &#128073;
                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="mx-1">
                    </label>
                </div>
                <div class="mt-2 text-red-700 text-lg font-bold text-center">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>

                <div>
                    <button type="submit" 
                    class="bg-blue-500 text-white font-bold rounded-full w-1/4 px-4 py-2 mt-3">Crear Categoría
                </button>
                </div>
            </form>
            <div class="mx-auto mt-2">
                <a href="{{ route('categories.index') }}" 
                class="bg-sky-500 text-white font-semibold rounded-md px-3 py-2">Ver Categorías</a>
            </div>
        </div>
        
    @endif
@endsection