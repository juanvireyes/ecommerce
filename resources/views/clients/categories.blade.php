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
    <div class="flex justify-center mx-auto gap-1">
    @foreach ($filtered_categories as $category)
        <div class="mx-auto px-4 py-2 mt-2">
            <img src="{{ asset(Storage::url($category['image'])) }}" 
            alt="{{ $category['name'] }}"
            class="w-48 h-auto text-center">
            <p class="text-center text-red-500 text-medium font-semibold mt-2 mx-auto">{{ $category['name'] }}</p>
        </div>
    @endforeach
    </div>
@endsection