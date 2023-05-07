@if (Auth::user()->hasRole(['admin', 'superadmin']))

@extends('template')

@section('title', 'Productos')

@section('content')

    <div class="container mx-auto my-auto py-4">
        <nav class="flex justify-center py-4">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:underline underline-offset-8 font-bold">Categorías</a>
            <a href="{{ route('subcategories.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:underline underline-offset-8 font-bold">Subcategorías</a>
            <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:underline underline-offset-8 font-bold">Productos</a>
        </nav>
    </div>

    <div class="container mx-auto">
        
        <div class="text-center mt-3 mb-3">
            <h1 class="text-red-600 text-2xl font-bold">Edición y creación de Productos</h1>
        </div>

        <div class="flex flex-row justify-left gap-4 mt-3 py-2 px-6">
            <form action="{{ route('products.index') }}" method="GET">
                <select name="categoryId" id="categoryId" class="text-left text-red-500 font-bold w-1/2">
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" 
                            @if ($categoryId == $category->id) 
                                selected 
                            @endif class="font-bold">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button type="submit"
                class="ml-4 px-4 py-2 rounded-md bg-red-500 text-black hover:text-white text-md font-bold">Ver subcategorías</button>
            </form>
        </div>

        @if (!empty($categoryId))
            <div class="flex flex-row justify-left gap-4 mt-3 py-2 px-6">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="flex">
                        <select name="subcategoryId" id="subcategoryId" class="text-left text-red-500 font-bold w-1/2">
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" 
                                    @if ($subcategory->id == $subcategory->id)
                                        selected
                                    @endif class="font-bold">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
    
                        <button type="submit" 
                        class="ml-4 px-4 py-2 rounded-md bg-red-500 text-black hover:text-white text-md font-bold inline-block">
                            Filtrar productos
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <div class="text-right mx-6 mb-4 pb-4">
            <a href="{{ route('products.create') }}" 
            class="bg-red-400 px-5 py-3 rounded-md drop-shadow-xl text-white font-semibold">
            Crear producto
            </a>
        </div>

        <div class="mx-auto mt-6 px-4">
            <table class="table-auto border border-separate mx-auto w-full">
                <thead>
                    <tr class="text-center">
                        <th scope="col" 
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Nombre Producto
                        </th>
                        <th scope="col" 
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Descripción
                        </th>
                        <th scope="col" 
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Precio
                        </th>
                        <th scope="col" 
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Stock
                        </th>
                        <th scope="col" 
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Disponible
                        </th>
                        <th scope="col" 
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Orden en el display
                        </th>
                        <th scope="col"
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Subcategoría
                        </th>
                        <th scope="col" 
                        class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="text-center">
                            <td class="border border-slate-300 py-4">
                                {{ $product->name }}
                            </td>
                            <td class="border border-slate-300 py-4 px-2">
                                {{ $product->description }}
                            </td>
                            <td class="border border-slate-300 py-4 px-2">
                                {{ $product->price }}
                            </td>
                            <td class="border border-slate-300 py-4 px-2">
                                {{ $product->stock }}
                            </td>
                            <td class="border border-slate-300 py-4 px-2">
                                {{ $product->active }}
                            </td>
                            <td class="border border-slate-300 py-4">
                                {{ $product->order }}
                            </td>
                            <td class="border border-slate-300 py-4 px-2">
                                <a href="{{ route('subcategories.index') }}" 
                                    class="text-gray-700 hover:text-red-500 text-sm font-bold">
                                    {{ $subcategory->name }}
                                </a>
                            </td>
                            <td class="border border-slate-300 py-4">
                                <div class="flex justify-items-center">
                                    <div class="mx-auto py-2 px-2">
                                        <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 text-white text-sm font-bold rounded-full px-4 py-1">Editar</a>
                                    </div>
                                    <div class="mx-auto py-2 px-2">
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                class="bg-yellow-300 text-medium font-bold hover:bg-black text-black hover:text-white rounded-full px-4">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            {{-- {{ $products->links() }} --}}
        </div>
    </div>

    </div>
@endsection
@endif