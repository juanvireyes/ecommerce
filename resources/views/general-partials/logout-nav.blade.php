<form action="{{ route('logout') }}" method="POST" class="inline-block">
    @csrf
    <button type="submit" class="text-red-500 mr-7">
        <img src="{{ asset('images/logout.png') }}" class="h-12 mx-auto">
        <p class="text-red-500 text-lg text-center font-bold">Logout</p>
    </button>
    <input type="hidden" name="_method" value="POST">
</form>