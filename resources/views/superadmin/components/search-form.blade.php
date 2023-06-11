<div class=" flex ml-4 px-4 py-2 justify-center items-center">
    <label for="search" class="text-red-500 text-lg font-bold mr-4">Buscar usuario</label>
    <form action="{{ route('superadmin.index') }}" method="GET">
        <input type="text" name="search" placeholder="Nombre o Email" value="{{ request('search') }}"
            class="border border-gray-200 rounded py-2 px-4">
        <button type="submit"
            class="bg-red-500 text-white text-m font-bold px-6 py-2 ml-2 rounded border">Buscar</button>
    </form>
</div>