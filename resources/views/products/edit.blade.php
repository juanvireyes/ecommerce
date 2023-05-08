@extends('template')

@section('title', 'Editar subcategoría')

@section('content')
    <div class="container mx-auto">
        @if (Auth::user()->hasRole(['admin', 'superadmin']))

            <div class="text-center">
                <form action="{{ route('products.edit', $product->id) }}" method="GET">
                    {{-- Categoría--}}
                    <div class="mt-3 mb-3">
                        <label for="categoryId" class="text-red-500 text-medium font-bold mx-auto mr-2"> Seleccionar categoría: </label>
                        <select name="categoryId" 
                        id="categoryId" 
                        class="w-1/4 text-red-500 font-bold mx-auto w-1/2"
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
            </div>

            <div class="flex flex-col mx-auto items-center justify-items-center">
                @if (session()->has('success'))
                    <div class="alert alert-success text-green-500 font-bold mt-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mx-auto mt-3 py-3">
                    @csrf
                    @method('PUT')

                    {{-- Image --}}
                    <div class="mt-4 mb-2 mx-auto">
                        <div class="mx-auto mb-2">
                            <img src="{{ asset(Storage::url($product->image)) }}" 
                            alt="{{ $product->name }}"
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
                            value="{{ $product->name }}"
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
                            class="w-full mt-2 py-2">{{ $product->description }}</textarea>
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
                        value="{{ $product->order }}" 
                        required>
                    </div>
                    @error('order')
                        <div class="mt-2 text-red-700 text-lg font-bold text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Precio --}}
                    
                    <div class="mt-3 mb-3 mx-auto text-center">
                        <label for="order" 
                        class="text-red-500 text-medium font-bold mr-2"> Precio: 
                        </label>
                        <input type="text" 
                        name="price" 
                        id="price"
                        min="0" 
                        class="w-1/4 text-red-500 font-bold"
                        value="{{ $product->price }}" 
                        required>
                    </div>
                    @error('price')
                        <div class="mt-2 text-red-700 text-lg font-bold text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Stock --}}
                    <div class="mt-3 mb-3 mx-auto text-center">
                        <label for="order" 
                        class="text-red-500 text-medium font-bold mr-2"> Stock: 
                        </label>
                        <input type="number" 
                        name="stock" 
                        id="stock"
                        min="0" 
                        class="w-1/4 text-red-500 font-bold"
                        value="{{ $product->stock }}" 
                        required>
                    </div>
                    @error('stock')
                        <div class="mt-2 text-red-700 text-lg font-bold text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Subcategoría --}}
                    @if (!empty($categoryId))
                        <div class="mt-3 mb-3">
                            <label for="subcategory_id" class="text-red-500 text-medium font-bold mx-auto mr-2"> Subcategoría: </label>
                            <select name="subcategory_id" 
                            id="subcategory_id" 
                            class="w-2/4 text-red-500 font-bold mx-auto"
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

                    {{-- Botón submit --}}
                    <div>
                        <button type="submit" 
                        class="bg-blue-500 text-white font-bold rounded-full w-full px-4 py-2 mt-3 mx-auto">Editar Productos
                    </button>
                    </div>
                </form>

                <div class="mx-auto mt-2">
                    <a href="{{ route('products.index') }}" 
                    class="bg-sky-500 text-white font-semibold rounded-md px-3 py-2">Ver Productos</a>
                </div>
            </div>
        @endif
    </div>
@endsection