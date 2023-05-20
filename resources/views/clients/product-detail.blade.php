@extends('template')

@section('title', 'Detalle producto')

@section('content')
    <div class="container mx-auto">
        <h1 
        class="text-red-500 text-center text-7xl font-bold mt-4 mb-3 py-3 underline underline-offset-4">
        {{$product->name}}</h1>

        <div class="flex gap-12 mt-4 py-4">

            <div class="flex flex-col w-1/2 h-auto">
                <img src="{{ asset(Storage::url($product->image)) }}" alt="{{ $product->name }}">
            </div>

            <div class="flex flex-col text-center">
                <p class="text-gray-500 text-xl text-center">{{ $product->description }}</p>
                <div class="flex gap-32 justify-center">
                    <div>
                        <h1 class="text-red-500 text-4xl font-semibold">En stock</h1>
                        <p class="text-gray-700 text-3xl font-bold">{{ $product->stock }}</p>
                    </div>
                    <div>
                        <h1 class="text-red-500 text-4xl font-semibold">Disponible</h1>
                        @if ($product->active === 1)
                            <p class="text-green-500 text-3xl font-bold">SI</p>
                        @else
                            <p class="text-red-500 text-3xl font-bold">NO</p>
                        @endif
                    </div>
                </div>
                <div></div>
            </div>
        </div>

        <div class="container mx-auto text-center">
            <div class="flex justify-center gap-32">
                <div>
                    <h1 
                    class="text-red-700 text-7xl font-bold mt-4 mb-4 py-2 underline underline-offset-6">
                    Precio</h1>
                    <p class="text-gray-600 text-5xl font-semibold">{{ $product->price }}</p>
                </div>
                <div>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="productId" value="{{ $product->id }}">

                        <div class="flex">
                            <div class="items-center mt-4 mb-4 py-3">
                                <label for="quantity" class="text-red-500 text-2xl font-semibold px-4">Cantidad</label>
                            </div>
                            <div class="items-center mt-4 mb-4 py-3">
                                <input type="number" name="quantity" id="quantity">
                            </div>
                        </div>

                        <button type="submit" class="bg-red-500 text-white font-bold px-2 py-4 rounded-full mx-auto">
                            Agregar al carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mx-auto text-center mt-10 py-4">
            <a 
            href="{{ route('clients.products', ['category_slug' => $category->slug, 'subcategory_slug' => $subcategory->slug, $product->slug]) }}"
            class="bg-sky-300 text-gray-700 font-bold hover:text-black rounded-full px-4 py-2">Volver a productos</a>
        </div>
    </div>
@endsection