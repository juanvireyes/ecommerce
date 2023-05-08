@extends('template')

@section('title', 'Editar subcategoría')

@section('content')
    <div>
        @if (Auth::user()->hasRole(['admin', 'superadmin']))
            <div class="flex flex-col mx-auto items-center justify-items-center">
                @if (session()->has('success'))
                    <div class="alert alert-success text-green-500 font-bold mt-4">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data" class="mx-auto mt-3 py-3">
                    @csrf
                    @method('PUT')

                    {{-- Image --}}
                    <div class="mt-4 mb-2 mx-auto">
                        <div class="mx-auto mb-2">
                            <img src="{{ asset(Storage::url($subcategory->image)) }}" 
                            alt="{{ $subcategory->name }}"
                            class="w-80 h-auto mx-auto">
                        </div>
                        <div class="mt-2 mb-1">
                            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="w-full">
                        </div>
                        @error('image')
                            <div class="mt-2 text-red-700 text-lg font-bold text-center">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="mt-2 mb-2 mx-auto w-full">
                        <label for="name" class="w-full">
                            <input type="text" 
                            name="name" id="name" 
                            value="{{ $subcategory->name }}"
                            class="w-full py-2 mt-2 text-red-500 font-bold"
                            autofocus>
                        </label>
                    </div>
                    @error('name')
                        <div class="mt-2 text-red-700 text-lg font-bold text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Description --}}
                    <div class="mt-2 mb-2 mx-auto w-full">
                        <label for="description" class="w-full">
                            <textarea 
                            name="description" id="description" 
                            class="w-full mt-2 py-2">{{ $subcategory->description }}</textarea>
                        </label>
                    </div>
                    @error('description')
                        <div class="mt-2 text-red-700 text-lg font-bold text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Order --}}
                    <div class="mt-3 mb-3 mx-auto text-center">
                        <label for="order" 
                        class="text-red-500 text-medium font-bold mr-2"> Orden en el display: 
                        </label>
                        <input type="number" 
                        name="order" 
                        id="order"
                        min="0" 
                        class="w-1/4 text-red-500 font-bold"
                        value="{{ $subcategory->order }}" 
                        required>
                    </div>
                    @error('order')
                        <div class="mt-2 text-red-700 text-lg font-bold text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Categoría --}}
                    <div class="mt-3-mb-3 py-2">
                        <label for="category" class="text-red-500 text-medium font-bold">
                            Selecciona la categoría
                            <select name="categories" id="categories" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    @error('categories')
                        <div class="mt-2 text-red-700 text-lg font-bold text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Botón submit --}}
                    <div>
                        <button type="submit" 
                        class="bg-blue-500 text-white font-bold rounded-full w-full px-4 py-2 mt-3 mx-auto">Editar Categoría
                    </button>
                    </div>
                </form>

                <div class="mx-auto mt-2">
                    <a href="{{ route('subcategories.index') }}" 
                    class="bg-sky-500 text-white font-semibold rounded-md px-3 py-2">Ver Subcategorías</a>
                </div>
            </div>
        @endif
    </div>
@endsection