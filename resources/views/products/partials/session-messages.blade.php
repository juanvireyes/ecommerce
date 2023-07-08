@if (session()->has('success'))
    <div class="alert alert-success text-green-500 text-sm font-bold text-center mt-4 py-2">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-success text-red-500 text-2xl font-bold text-center mt-4 py-2">
        {{ session('error') }}
    </div>
@endif