@if (Auth::user()->hasRole(['admin', 'superadmin']))

@extends('template')

@section('title', 'Categorías')

@section('content')
<div class="container mx-auto">
    <div class="text-center mt-3 mb-3">
        <h1 class="text-red-600 text-2xl font-bold">Edición y creación de Categorías</h1>
    </div>
    <div class="text-right mx-6 mb-4 pb-4">
        <a href="{{ route('categories.create') }}" 
        class="bg-red-400 px-5 py-3 rounded-md drop-shadow-xl text-white font-semibold">
        Crear categoría
        </a>
    </div>
    <div class="mx-auto mt-6 px-4">
        <table class="table-auto border border-separate mx-auto w-full">
            <thead>
                <tr class="text-center">
                    <th scope="col" 
                    class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                        Nombre categoría
                    </th>
                    <th scope="col" 
                    class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                        Descripción
                    </th>
                    <th scope="col" 
                    class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                        Orden en el display
                    </th>
                    <th scope="col" 
                    class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="text-center">
                        <td class="border border-slate-300 py-4">
                            {{ $category->name }}
                        </td>
                        <td class="border border-slate-300 py-4 px-2">
                            {{ $category->description }}
                        </td>
                        <td class="border border-slate-300 py-4">
                            {{ $category->order }}
                        </td>
                        <td class="border border-slate-300 py-4">
                            <div class="flex justify-items-center">
                                <div class="mx-auto py-2 px-2">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="bg-blue-500 text-white text-sm font-bold rounded-full px-4 py-1">Editar</a>
                                </div>
                                <div class="mx-auto py-2 px-2">
                                    <a href="#" 
                                    class="bg-yellow-300 hover:bg-black text-black hover:text-white font-bold text-sm font-bold rounded-full px-4 py-1">
                                        Eliminar
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@endif