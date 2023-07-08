<form action="{{ route('products.index') }}" method="GET">
    <select name="categoryId" id="categoryId" class="text-left text-red-500 font-bold w-1/2">
        <option value=""></option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" 
                @if ($categoryId == $category->id) 
                    selected 
                @endif class="font-bold">{{ $category->name }}</option>
        @endforeach
    </select>

    <button type="submit"
    class="ml-4 px-4 py-2 rounded-md bg-red-500 text-black hover:text-white text-md font-bold"
    >Ver subcategorías</button>
</form>