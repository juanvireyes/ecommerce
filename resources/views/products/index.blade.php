@if (Auth::user()->hasRole(['admin', 'superadmin']))

@extends('template')

@section('title', 'Productos')

@section('content')

    @include('products.partials.session-messages')

    @include('products.partials.products-nav')

    <div class="container mx-auto">

        <div class="text-center mt-3 mb-3">
            <h1 class="text-red-600 text-2xl font-bold">Edición y creación de Productos</h1>
        </div>

        @include('products.partials.search-bar')

        <div class="flex flex-row justify-left gap-4 mt-3 py-2 px-6">

            @include('products.partials.category-select')

            @include('products.partials.price-order')


        </div>

        @include('products.partials.subcategory-select')

        <div class="flex justify-between mt-4">

            @include('products.partials.create-product')

            @include('products.partials.download-products')

            @include('products.partials.upload')
        </div>

        @include('products.partials.products-table')

    </div>

@endsection
@endif
