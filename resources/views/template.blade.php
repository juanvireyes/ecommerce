<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <div class="container px-4 mx-auto">
        <header class="flex justify-between items-center py-4 bg-gray-300">
            
            @include('general-partials.home-nav')
            
            <div class="flex items-center">
                @auth

                    @include('general-partials.cart-nav')

                    <div class="ml-auto flex items-center">
                        
                        @include('general-partials.dashboard-nav')
                        
                        @include('general-partials.profile-edit')

                        @include('general-partials.logout-nav')
                    </div>
                @else
                
                    @include('general-partials.no-logged-nav')
                
                @endauth
            </div>
        </header>
    </div>


    @yield('content')

    @include('general-partials.bottom-icon')

</body>

</html>
