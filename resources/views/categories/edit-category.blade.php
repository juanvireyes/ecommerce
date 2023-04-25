@extends('template')

@section('title', 'Editar categoría')

@section('content')
    <div class="container mx-auto">
        @if (Auth::user()->hasRole(['admin', 'superadmin']))
            <div class="flex flex-col mx-auto items-center justify-items-center">
                @if (session()->has('success'))
                    <div class="alert alert success text-green-500 font-bold mt-4">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('categories.update', $category) }}" 
                method="POST"
                enctype="multipart/form-data" 
                class="mx-auto mt-3 py-3">
                    @csrf
                    @method('PUT')

                    {{-- Image --}}
                    <div class="mt-4 mb-2 mx-auto">
                        <div class="mx-auto mb-2">
                            <img 
                            src="{{ asset(Storage::url($category->image)) }}" 
                            alt="{{ $category->name }}"
                            class="w-80 h-auto mx-auto">
                        </div>
                        <div class="mt-2 mb-1">
                            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="w-full">
                        </div>
                    </div>

                    {{-- Nombre --}}
                    <div class="mt-2 mb-2 mx-auto w-full">
                        <label for="name" class="w-full">
                            <input type="text" 
                            name="name" id="name" 
                            value="{{ $category->name }}"
                            class="w-full py-2 mt-2 text-red-500 font-bold"
                            autofocus>
                        </label>
                    </div>
                    <div class="mt-2 text-red-700 text-lg font-bold text-center">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="mt-2 mb-2 mx-auto w-full">
                        <label for="description" class="w-full">
                            <textarea 
                            name="description" id="description" 
                            class="w-full mt-2 py-2">{{ $category->description }}</textarea>
                        </label>
                    </div>
                    <div class="mt-2 text-red-700 text-lg font-bold text-center">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>

                    {{-- Order --}}
                    <div class="mt-3 mb-3 mx-auto text-center">
                        <label for="order" 
                        class="text-red-500 text-medium font-bold mr-2"> Orden en el display: 
                        </label>
                        <input type="number" 
                        name="order" 
                        id="order"
                        min="0"
                        value="{{ $category->order }}" 
                        class="w-1/4 text-red-500 font-bold" 
                        required>
                    </div>
                    <div>
                        @error('order')
                            {{ $message }}
                        @enderror
                    </div>

                    {{-- Botón submit --}}
                    <div>
                        <button type="submit" 
                        class="bg-blue-500 text-white font-bold rounded-full w-full px-4 py-2 mt-3 mx-auto">Editar Categoría
                    </button>
                    </div>
                </form>
                <div class="mx-auto mt-2">
                    <a href="{{ route('categories.index') }}" 
                    class="bg-sky-500 text-white font-semibold rounded-md px-3 py-2">Ver Categorías</a>
                </div>
            </div>
        @endif
    </div>
@endsection