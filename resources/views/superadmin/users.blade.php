@extends('template')

@section('title', 'User management')

@section('content')
    <div class="mx-auto mt-4 px-4 py-2">
        <h1 class="text-center text-red-500 text-2xl font-bold">Usuarios</h1>
    </div>
    <div class=" flex ml-4 px-4 py-2 items-center">
        <label for="search" class="text-red-500 text-lg font-bold mr-4">Buscar usuario</label>
        <form action="{{ route('superadmin.index') }}" method="GET">
            <input type="text" name="search" placeholder="Nombre o Email" value="{{ request('search') }}"
                class="border border-gray-200 rounded py-2 px-4">
            <button type="submit"
                class="bg-red-500 text-white text-m font-bold px-6 py-2 ml-2 rounded border">Buscar</button>
        </form>
    </div>
    <div class="flex flex-col mt-5">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 px-4">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                                    Nombre Usuario
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-red-500 font-bold uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if ($user->is_active == 1)
                                            <img src="{{ asset('images/active.png') }}" class="h-5 mx-auto">
                                        @else
                                            <img src="{{ asset('images/inactive.png') }}" class="h-5 mx-auto">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
