@extends('template')

@section('title', 'User Dashboard')

@section('content')
    @auth
        <div class="container mx-auto px-6 py-4 items-center">
            <h1 class="text-center text-red-600 text-2xl font-bold mb-6">Bienvenido {{ $user->name }}</h1>

            @if (Auth::user()->hasRole('superadmin'))

                <div class="flex justify-center text-center">

                    @include('users.partials.users-management')

                    @include('users.partials.categories-management')

                    @include('users.partials.products-management')

                </div>

                <div class="flex justify-center text-center mt-8 py-3">

                    @include('users.partials.client-orders')

                    @include('users.partials.reports')

                </div>

            @elseif (Auth::user()->hasRole('admin'))

                <div class="flex justify-center text-center">

                    @include('users.partials.categories-management')

                    @include('users.partials.products-management')

                    @include('users.partials.client-orders')

                </div>

                <div class="flex justify-center text-center mt-8 py-3">

                    @include('users.partials.reports')

                </div>
            @else

                <div class="flex justify-center text-center">

                    @include('users.partials.client-products')

                    @include('users.partials.client-orders')

                </div>
            @endif
        </div>
    @endauth
@endsection
