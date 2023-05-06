@extends('clients.vitrina-template')

@section('categories')
@section('content-name', 'Subcategorías')
    
    <div class="bg-gray-200 grid grid-cols-4 justify-center mx-auto gap-1 justify-center items-center px-4 py-6 mt-8">
    @foreach ($subCategories as $subCategory)
        <a href="{{ route('clients.subcategories', $category['slug']) }}">
            <div class=" bg-white mx-auto px-8 py-12 mt-2 mb-4 w-64 h-64 rounded-full shadow-xl flex flex-col justify-center items-center gap-1">
                <img src="{{ asset(Storage::url($subCategory['image'])) }}" 
                alt="{{ $subCategory['name'] }}"
                class="w-1/2 h-auto text-center items-center">
                <p class="text-center text-red-500 text-medium font-semibold mt-2 mx-auto hover:font-bold">{{ $subCategory['name'] }}</p>
            </div>
        </a>
    @endforeach
    </div>
    <div class=" flex mx-auto justify-center mt-4 py-2">
        <a href="{{ route('clients.index') }}" 
        class="bg-sky-300 text-gray-700 font-bold hover:text-black rounded-full px-4 py-2">Volver a categorías</a>
    </div>
@endsection