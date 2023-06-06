@extends('template')

@section('title', 'Testing')

@section('content')
    {{-- <div id="app">
        <custom-component :products="{{ json_encode($products) }}" />

    </div> --}}

    <div class="container mx-auto">
        @if (session()->has('error'))
            <div>
                {{ session('error') }}
            </div>
        @endif
        <div class="flex flex-col justify-center items-center mt-4 mb-4 px-2 py-2">
            <table>
                <thead>
                    <tr>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Código producto
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Nombre producto
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Precio Unitario
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Agregar
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $product->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $product->price }}
                            </td>
                            <div class="text-center">
                                <td class="px-6 py-4 text-sm font-medium flex gap-1">
                                    <div class="inline-flex items-center">
                                        <form action="{{ route('testingcart.add') }}" method="POST" class="mr-2">
                                            @csrf
                                            
                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}" />

                                            <input type="number"
                                            name = "quantity" 
                                            min="0" 
                                            value="0" 
                                            class="px-2 mx-2"
                                            required>
                                            <button type="submit" 
                                            class="bg-sky-400 text-black font-xs px-2 py-3 rounded-md">
                                                Agregar producto
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </div>
                        </tr>
                    @endforeach
                    <div>
                        @error('product_id')
                                <div>
                                    {{ $message }}
                                </div>
                            @enderror
                            @error('quantity')
                                {{ $message }}
                            @enderror
                    </div>
                </tbody>
            </table>

            <div class="gap-4 justify-between">
                {{ $products->links() }}
            </div>

            <div class="mt-4 px-2 py-3">
                <a href="{{ route('testingcart.show') }}" 
                class="bg-sky-300 text-black text-sm font-semibold rounded-md px-4 py-2">Ver carrito</a>
            </div>

            {{-- <div class="flex flex-row justify-center mt-2 py-2">
                <p class="text-red-500 text-2xl font-bold">Precio total: <span class="text-black">{{ $cartItems->total }}</span></p>
            </div> --}}
        </div>

    </div>
@endsection