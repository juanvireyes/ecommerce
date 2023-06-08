<div class="inline-block mr-7">
    <a href="{{ route('profile.edit') }}" class="text-red-500 text-lg text-center font-bold">
        <img src="{{ asset('images/user.png') }}" class="h-12 mx-auto">
        <p class="text-red-500 text-lg text-center font-bold">{{ Auth::user()->name }}</p>
    </a>
</div>