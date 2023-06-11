@extends('template')

@section('title', 'Orden de compra')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-red-600 text-2xl font-bold mt-4 mx-auto text-center">
            Órdenes de compra
        </h1>

        @include('orders.components.order-filter-form')

        @include('orders.components.orders-table')
    </div>
@endsection