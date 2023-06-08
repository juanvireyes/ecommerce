@extends('template')

@section('title', 'Orden de compra')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-red-600 text-2xl font-bold mt-4 mx-auto text-center">
            Órdenes de compra
        </h1>

        <div class="flex flex-row justify-center items-center text-center mt-2 py-2 mx-auto px-2">
            <table class="text-center">
                <thead>
                    <tr>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Número orden
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Cliente orden
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Valor total
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $order->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                {{ $order->total }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                @if ($order->status == 'pending')
                                    <span class="text-red-500 text-sm uppercase font-bold">Pendiente</span>
                                @elseif($order->status == 'completed')
                                    <span class="text-red-500 text-sm uppercase font-bold">Completado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                <div class="flex gap-4 justify-center text-center">
                                    <div>
                                        <form action="{{ route('orders.payment', $order->id) }}" method="post">
                                            @csrf

                                            <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">

                                            <button type="submit">Pagar</button>
                                        </form>
                                    </div>
                                    <div>
                                        <a href="{{ route('orders.show', $order) }}"
                                        class="bg-yellow-400 text-black text-sm font-bold px-3 py-2 rounded-full">
                                            Ver detalles
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