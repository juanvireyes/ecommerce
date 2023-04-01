@extends('template')

@section('title', 'Gestión de usuarios')

@section('content')
<div class="container mx-auto px-4 py-2">
    
    @can('update', $user)
        <div class="container mx-auto text-center mt-4">

            <div class="border p-4 rounded">
                <h1 class="text-lg text-red-700 font-bold mx-auto mt-2 mb-2">{{  $user->name }}</h1>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" class="inline-block">
                @csrf
                @method('PUT')

                <div class="grid mx-auto">
                    <div class="grid mb-3 mx-auto rounded">
                        <p class="text-center text-red-500 font-bold mb-1">Correo electrónico</p>
                        <div class="border p-4 bg-gray-100 rounded">
                            <p class="text-center text-gray-500 font-bold text-m">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="grid mb-3 mx-auto rounded">
                        <label for="cellphone" class="text-center text-red-500 font-bold mb-1">Teléfono Celular</label>
                        <input type="text" name="cellphone" class="rounded text-center text-m" value="{{ $user->cellphone }}" autofocus>
                        @error('cellphone'){{ $message }}@enderror
                    </div>
                </div>

                <div class="grid">
                    <div class="grid mb-3 mx-auto rounded">
                        <label for="address" class="text-center text-red-500 font-bold mb-1">Dirección</label>
                        <input type="text" name="address" class="rounded text-center text-m" value="{{ $user->address }}">
                        @error('address'){{ $message }}@enderror
                    </div>

                    <div class="grid mb-3 mx-auto rounded">
                        <label for="city" class="text-red-500 font-bold">Ciudad</label>
                        <input type="text" name="city" class="rounded text-center text-m mb-1" value="{{ $user->city }}">
                        @error('city'){{ $message }}@enderror
                    </div>

                    <div class="grid mb-3 mx-auto rounded">
                        <label for="state" class="text-red-500 font-bold">Departamento / Estado</label>
                        <input type="text" name="state" class="rounded text-center text-m mb-1" value="{{ $user->state }}">
                        @error('state'){{ $message }}@enderror
                    </div>

                    <div class="grid mb-3 mx-auto rounded">
                        <label for="country" class="text-red-500 font-bold">País</label>
                        <input type="text" name="country" class="rounded text-center text-m mb-1" value="{{ $user->country }}">
                        @error('country'){{ $message }}@enderror
                    </div>

                    <div class="inline-flex mx-auto items-center">
                        <label for="is_active" class="text-red-500 font-bold mr-2">Activo</label>
                        <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                        <button type="submit" class="text-center text-indigo-600 hover:text-indigo-900 ml-12 font-bold">Actualizar</button>
                    </div>
                </div>
            </form>
            @if (session()->has('success'))
                <div class="alert alert success text-green-500 font-bold mt-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    @endcan
</div>

@endsection