@extends('template')

@section('title', 'Crear producto')

@section('content')
    @if (Auth::user()->hasRole(['admin', 'superadmin']))
        <div class="container mx-auto px-4 py-4 text-center">
            <h1 class="text-red-500 text-2xl font-bold">Crear producto</h1>

            <form action="{{ route('products.create') }}" method="GET">
            {{-- Categoría--}}
            <div class="mt-3 mb-3">
                <label for="categoryId" class="text-red-500 text-medium font-bold mx-auto mr-2"> Seleccionar categoría: </label>
                <select name="categoryId" 
                id="categoryId" 
                class="w-1/4 text-red-500 font-bold mx-auto"
                required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($categoryId == $category->id)
                            selected
                        @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" 
            class="bg-sky-500 hover:bg-red-500 text-gray-700 font-semibold hover:text-black rounded-md px-2 py-3">
            Selecciona la categoría</button>
            </form>

            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="py-3">
                @csrf

                {{-- Nombre --}}
                <div class="mt-3 mb-3">
                    <label for="name">
                        <input type="text" name="name" id="name" placeholder="Nombre Producto" 
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

                {{-- descripción --}}
                <div class="mt-3 mb-3">
                    <label for="description">
                        <textarea name="description" id="description" placeholder="Descripción Producto"
                        class="w-1/2"
                        autocomplete="description"></textarea>
                    </label>
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>

                {{-- precio --}}
                <div class="mt-3 mb-3">
                    <label for="price">
                        <input type="text" name="price" id="price" placeholder="Precio">
                    </label>
                    @error('price')
                        {{ $message }}
                    @enderror
                </div>

                {{-- stock --}}
                <div class="mt-3 mb-3">
                    <label for="stock">
                        <input type="number" name="stock" id="stock" placeholder="Cantidad disponible" min="0">
                    </label>
                    @error('stock')
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
                    class="w-1/4 text-red-500 font-bold mx-auto">
                </div>
                <div>
                    @error('order')
                        {{ $message }}
                    @enderror
                </div>
            
                {{-- Subcategoría --}}
                @if (!empty($categoryId))
                    <div class="mt-3 mb-3">
                        <label for="subcategory_id" class="text-red-500 text-medium font-bold mx-auto mr-2"> Seleccionar Subcategoría: </label>
                        <select name="subcategory_id" 
                        id="subcategory_id" 
                        class="w-1/4 text-red-500 font-bold mx-auto"
                        required>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" class="font-bold">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 text-red-700 text-lg font-bold text-center">
                        @error('subcategory')
                            {{ $message }}
                        @enderror
                    </div>
                @endif

                {{-- Imagen --}}
                <div class="mt-3 mb-3">
                    <label for="file" 
                    class="text-red-500 text-medium font-bold"> 
                    Selecciona una imagen para el producto &#128073;
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
                    class="bg-blue-500 text-white font-bold rounded-full w-1/4 px-4 py-2 mt-3">Crear Producto
                </button>
                </div>
            </form>
        </div>

    @endif
@endsection