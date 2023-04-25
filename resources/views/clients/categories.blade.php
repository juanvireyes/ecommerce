@extends('clients.vitrina-template')

@section('categories')
    <div class="flex justify-center">
        <form action="{{ route('home') }}" method="GET" class="mx-auto justify-center">
            <label for="search" class="mx-auto text-red-700 text-center font-bold text-md mr-3">Buscar: </label>
            <input 
            type="text" 
            name="filter" 
            placeholder="Buscar" 
            class="w-2/4 text-red-500 text-sm mx-auto mb-4 py-2">
            <button type="submit" 
            class="bg-red-500 hover:bg-red-300 text-white hover:text-black font-semibold rounded-md px-4 py-2 ml-3">
            Buscar</button>
        </form>
    </div>
    <div class="grid grid-cols-4 justify-center mx-auto gap-1 justify-center items-center">
    @foreach ($filtered_categories as $category)
        <a href="#">
            <div class="mx-auto px-8 py-12 mt-2 mb-4 w-64 h-64 rounded-full shadow-xl flex flex-col justify-center items-center gap-1 hover:bg-sky-100">
                <img src="{{ asset(Storage::url($category['image'])) }}" 
                alt="{{ $category['name'] }}"
                class="w-1/2 h-auto text-center items-center">
                <p class="text-center text-red-500 text-medium font-semibold mt-2 mx-auto">{{ $category['name'] }}</p>
            </div>
        </a>
    @endforeach
    </div>
@endsection