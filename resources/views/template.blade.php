<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container px-4 mx-auto">
        <header class="flex justify-between items-center py-4 bg-gray-300">
            <div class="flex items-center flex-grow gap-4">
                <a href="{{ route('home') }}" class="px-4">
                    <img src="{{ asset('images/logo.png') }}" class="h-12 mx-auto">
                    <p class="text-red-500 text-lg text-center font-bold">Mercatodo</p>
                </a>
            </div>
            <div class="flex items-center">
                @auth
                    <div class="ml-auto flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-red-500 mr-6">
                            <img src="{{ asset('images/dashboard.png') }}" class="h12 w-12 mx-auto">
                            <p class="text-red-500 text-lg text-center font-bold">Dashboard</p>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="text-red-500 mr-7">
                                <img src="{{ asset('images/logout.png') }}" class="h-12 mx-auto">
                                <p class="text-red-500 text-lg text-center font-bold">Logout</p>
                            </button>
                            <input type="hidden" name="_method" value="POST">
                        </form>
                    </div>
                @else
                    <div class="ml-auto flex items-center">
                        <a href="{{ route('register') }}" class="text-red-500 mr-6">
                            <img src="{{ asset('images/signup.png') }}" class="h12 w-12 mx-auto">
                            <p class="text-red-500 text-lg text-center font-bold">Regístrate</p>
                        </a>
                        <a href="{{ route('login') }}" class="text-red-500 mr-7">
                            <img src="{{ asset('images/login.png') }}" class="h-12 mx-auto">
                            <p class="text-red-500 text-lg text-center font-bold">Login</p>
                        </a>
                    </div>
                @endauth
            </div>
        </header>
    </div>
    

    @yield('content')

    <p class="py-16">
        <img src="{{ asset('images/logo.png') }}" class="h-12 mx-auto">
    </p>
    
</body>
</html>