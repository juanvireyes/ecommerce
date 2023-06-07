@extends('template')

@section('title', 'Carrito de compra')

@section('content')

@if ($isEmpty)
    <div class="container mx-auto">
        <div class="text-center mt-4 mb-2">
            <h1 class="text-red-600 text-2xl font-bold py-2">No tienes productos agregados todavía</h1>
        </div>
        <div class="text-center mt-4 py-2">
            <a href="{{ route('clients.index') }}" class="bg-sky-300 text-black text-2xl px-2 py-2 rounded-md text-center">
                Agregar productos
            </a>
        </div>
    </div>
@else
    <div class="container mx-auto">
        <div class="flex flex-col justify-center items-center mt-4 mb-4 px-2 py-2">
            <table>
                <thead>
                    <tr>
                        <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Código producto
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Nombre producto
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Precio Unitario
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Cantidad
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Precio total
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->product_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->item_total_amount }}
                            </td>
                            <div class="text-center">
                                <td class="px-6 py-4 text-sm font-medium flex gap-1">
                                    <div class="inline-flex items-center">
                                        <form action="{{ route('cart.update', $cartItem) }}" method="POST" class="mr-2">
                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="cart_id" value="{{ $cartItem->cart_id }}">

                                            <input type="hidden" name="productId" />

                                            <input type="number"
                                            name="quantity" 
                                            min="1" 
                                            value="{{ $cartItem->quantity }}" 
                                            class="px-2 mx-2"
                                            required>
                                            <button type="submit" 
                                            class="bg-sky-400 text-black font-xs px-2 py-2">
                                                Aumentar cantidad
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.destroy', $cartItem) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="cart_id" value="{{ $cartItem->cart_id }}">

                                            <button type="submit">
                                                <img src="{{ asset('images/trash-can.png') }}" 
                                                alt="Eliminar" 
                                                class="h-12 w-auto text-left">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex flex-row justify-center mt-2 py-2">
                <p class="text-red-500 text-2xl font-bold">Precio total: <span class="text-black">{{ $cart->total_amount }}</span></p>
            </div>

            <div class="flex flex-row justify-center mt-2 my-2">
                <a href="{{ route('orders.index') }}" 
                class="bg-red-300 text-black text-2xl font-bold px-3 py-3 rounded-md">
                    Seguir al checkout
                </a>
            </div>

            <div class="flex flex-row justify-center mt-2 my-2">
                <a href="{{ route('clients.index') }}" 
                class="bg-sky-300 text-black text-xl font-semibold px-2 py-2 rounded-md">
                    Agregar más productos
                </a>
            </div>

            <div class="flex flex-row justify-center mt-2 my-2">
                <form action="{{ route('cart.clear', $cart) }}" method="post">
                    @csrf

                    <button type="submit" 
                    class="bg-sky-300 text-black text-medium font-bold px-2 py-2 rounded-md">
                        Limpiar carrito
                    </button>
                </form>
            </div>

        </div>

    </div>
@endif

@endsection