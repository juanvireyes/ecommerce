@extends('template')

@section('title', 'Gestión de usuarios')

@section('content')
<div class="container mx-auto px-4 py-2">
    <h1 class="text-center text-lg font-medium">{{ $user->name }}</h1>
    <p class="mt-2 text-center text-sm text-gray-500">{{ $user->email }}</p>
    <p class="mt-2 text-center text-sm text-gray-500">{{ $user->address }}</p>
    <p class="mt-2 text-center text-sm text-gray-500">{{ $user->city }}, {{ $user->state }}, {{ $user->country }}</p>

    @can('update', $user)
        <div class="container mx-auto justify-center mt-4">
            <span class="text-center text-gray-500 mr-2">{{ $user->is_active ? 'Activo' : 'Inactivo' }}</span>

            <form action="{{ route('users.update', $user) }}" method="POST" class="inline-block">
                @csrf
                @method('PUT')
                <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                <button type="submit" name="is_active" value="{{ $user->is_active ? 0 : 1 }}" class="text-center text-indigo-600 hover:text-indigo-900">{{ $user->is_active ? 'Inhabilitar' : 'Habilitar' }}</button>
            </form>
        </div>
    @endcan
</div>

@endsection