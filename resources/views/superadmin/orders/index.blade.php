@extends('template')

@section('title', 'Administración de órdenes')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-red-600 text-center text-2xl mt-4 py-2 font-bold">
            Tabla de órdenes de {{ $user->name }}
        </h1>

        @if (count($user->orders) < 1)
            <div class="flex flex-row justify-center items-center">
                <h1 class="bg-yellow-500 text-black text-center text-xl px-3 py-3 font-bold">
                    El cliente {{ $user->name }} no tiene órdenes creadas
                </h1>
            </div>

            @include('superadmin.components.back-button')

        @else
            
            @include('orders.components.orders-table')

            @include('superadmin.components.back-button')

        @endif

    </div>
@endsection