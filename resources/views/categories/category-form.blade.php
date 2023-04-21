@extends('template')

@section('title', 'Crear categoría')

@section('content')
    <div class="container mx-auto px-4 py-4 text-center">
        <h1 class="text-red-500 text-2xl font-bold">Crear categoría</h1>
        <form action="" method="POST">
        @csrf    

            {{-- Nombre categoría --}}
            <div class="mt-3 mb-3">
                <label for="name">
                    <input type="text" name="name" id="name" placeholder="Nombre Categoría" 
                    class="w-1/2" 
                    required 
                    autofocus 
                    autocomplete="name">
                </label>
            </div>

            {{-- Descripción --}}
            <div class="mt-3 mb-3">
                <label for="description">
                    <textarea name="description" id="description" placeholder="Descripción categoría"
                    class="w-1/2"
                    autocomplete="description"></textarea>
                </label>
            </div>

            {{-- Imagen --}}
            <div class="mt-3 mb-3">
                <label for="file">
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .pdf">
                </label>
            </div>

            <div>
                <button type="submit" 
                class="bg-blue-500 text-white font-bold rounded-full w-1/4 px-4 py-2 mt-3">Crear Categoría
            </button>
            </div>
        </form>
    </div>
@endsection