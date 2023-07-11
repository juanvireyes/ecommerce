<div class="mx-6 mb-4 py-4">
    <form action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="productsFile" id="productsFile">
        <button type="submit" class="bg-red-400 px-5 py-3 rounded-md drop-shadow-xl text-white font-semibold">
            Subir archivo
        </button>
    </form>
    @error('file')
        {{ $message }}
    @enderror
</div>
