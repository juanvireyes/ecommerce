@extends('template')

@section('title', 'Carrito de compra')

@section('content')

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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->qty }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $cartItem->itemTotal }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex flex-row justify-center mt-2 py-2">
                <p class="text-red-500 text-2xl font-bold">Precio total: <span class="text-black">{{ $cartItems->total }}</span></p>
            </div>
        </div>

    </div>

@endsection