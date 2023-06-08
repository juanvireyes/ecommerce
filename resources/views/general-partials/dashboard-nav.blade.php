@if (Auth::user()->hasRole(['superadmin', 'admin']))
    <a href="{{ route('user.dashboard') }}" class="text-red-500 mr-6">
        <img src="{{ asset('images/admindash.png') }}" class="h12 w-12 mx-auto">
        <p class="text-red-500 text-lg text-center font-bold">Dashboard</p>
    </a>
@else
    <a href="{{ route('user.dashboard') }}" class="text-red-500 mr-6">
        <img src="{{ asset('images/dashboard.png') }}" class="h12 w-12 mx-auto">
        <p class="text-red-500 text-lg text-center font-bold">Dashboard</p>
    </a>
@endif