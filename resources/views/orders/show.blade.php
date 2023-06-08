@extends('template')

@section('title', 'Detalle orden')

@section('content')
    <div class="container mx-auto mt-4">
        @if ($order->order_number != null)
            <h1 class="text-red-600 text-xl font-bold text-center">Detalles de orden # {{ $order->order_number }}</h1>
        @else
            <h1 class="text-red-600 text-xl font-bold text-center">Detalles de la orden</h1>
        @endif

        <div class="flex flex-col items-center justify-center gap-4 mt-4">

            <table class="text-center justify-center items-center mx-auto border-solid border-2">
                <thead>

                    <tr>
                        <div class="flex gap-2 justify-center">
                            <th scope="col" 
                            class="text-red-500 text-md text-center font-semibold uppercase border-solid border-2 px-3 py-2">
                                Detalles
                            </th>
                        </div>
                        <th scope="col" 
                        class="text-red-500 text-md text-center font-semibold uppercase border-solid border-2 px-3 py-2">
                            Precio
                        </th>
                        <th scope="col" 
                        class="text-red-500 text-md text-center font-semibold uppercase border-solid border-2 px-3 py-2">
                            Cantidad
                        </th>
                        <th scope="col" 
                        class="text-red-500 text-md text-center font-semibold uppercase border-solid border-2 px-3 py-2">
                            Precio total
                        </th>
                    </tr>
                
                </thead>

                <tbody>
                    @foreach ($orderItems as $orderItem)
                        <tr>
                            <td class="border-solid border-2 px-3 py-2">
                                <div>
                                    <img src="{{ asset(Storage::url($orderItem->product->image)) }}" 
                                    alt="{{ $orderItem->product->name }}"
                                    class="h-12 w-auto text-center mx-auto">
                                </div>
                                <div>
                                    <p class="text-red-500 text-xs text-center font-semibold uppercase px-3 py-2">
                                        {{ $orderItem->product->name }}
                                    </p>
                                </div>
                            </td>
                            <td class="text-black text-md text-center font-semibold uppercase border-solid border-2 px-3 py-2">
                                USD ${{ $orderItem->price }}
                            </td>
                            <td class="text-black text-md text-center font-semibold uppercase border-solid border-2 px-3 py-2">
                                {{ $orderItem->quantity }}
                            </td>
                            <td class="text-black text-md text-center font-semibold uppercase border-solid border-2 px-3 py-2">
                                USD ${{ $orderItem->product_total }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="justify-center">
                <h1 
                class="text-red-600 text-xl font-bold uppercase px-3 py-2">
                    Valor total de la orden: 
                    <span class="text-black">
                        {{ $order->total }}
                    </span>
            </h1>
            </div>

            <div class="justify-center">
                <h1 class="text-red-600 text-xl font-bold uppercase px-3 py-2">
                    Estado de la orden:
                    @if ($order->status == 'pending')
                        <span class="text-red-500 font-semibold uppercase">
                            Pendiente
                        </span>
                    @elseif($order->status == 'approved')
                        <span class="text-yellow-700 bg-gray-500 font-semibold px-3 py-2 uppercase">
                            En proceso
                        </span>
                    @elseif($order->status == 'rejected')
                        <span class="text-red-500 font-bold px-3 py-3 font-bold uppercase">
                            Rechazada
                        </span>
                    @else
                        <span class="text-green-500 font-semibold font-bold uppercase">
                            Completada
                        </span>
                    @endif
                </h1>
            </div>

            <div class="justify-center mt-2">
                <a href="{{ route('orders.index') }}"
                class="bg-sky-300 tex-black text-md font-bold px-3 py-2 rounded-md">
                    Volver al listado de órdenes
                </a>
            </div>

        </div>
    </div>
@endsection