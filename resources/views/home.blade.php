@extends('template')

@section('title', 'home')

@section('content')

<div class="justify-center flex-col items-center">
    <div class="px-20 py-16 rounded-lg mb-8 relative overflow-hidden">
        <h1 class="text-center text-red-600 text-2xl font-bold">Bienvenido a MercaTodo</h1>
        <p class="text-center">MercaTodo, el lugar donde puedes encontrar todo lo que necesites</p>
    </div>
    <div class="mt-4 rounded-lg relative overflow-hidden mx-auto grid grid-rows-2 justify-items-center align-items-center">
        @auth
            @if (count(Auth::user()->roles) > 0)
                <p class="text-center text-red-500 text-lg text-bold">Tus roles son:</p>
                <ul class="items-center">
                    @foreach (Auth::user()->roles as $role)
                        <li>{{ $role->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-center text-red-700 text-2xl font-bold">No tienes roles asignados con este usuario</p>
            @endif
        @endauth
    </div>
</div>
    
@endsection