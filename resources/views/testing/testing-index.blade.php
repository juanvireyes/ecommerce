@extends('template')

@section('title', 'Testing')

@section('content')
    <div>
        <div class="mx-auto text-center mt-3 mb-3 py-3 w-full">
            <form action="{{ route('testing') }}" method="get">
                
                <label for="search" class="text-red-600 text-md font-semibold">Buscar producto</label>
        
                <input type="text" name="search" id="search" placeholder="Nombre producto">
        
                <button type="submit"
                class="ml-4 px-4 py-2 rounded-md bg-red-500 text-black hover:text-white text-md font-bold"
                >Buscar</button>
        
            </form>
        </div>

        <ul>
            @foreach ($products as $product)
                <li>{{ $product->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection