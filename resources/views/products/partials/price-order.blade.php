<form action="{{ route('products.index') }}" method="get">

    <label for="price">
        Ordenar productos
    </label>
    <select name="price" id="price">
        <option value=""></option>
        <option value="desc">Mayor a menor precio</option>
        <option value="asc">Menor a mayor precio</option>
    </select>

    <button type="submit"
    class="ml-4 px-4 py-2 rounded-md bg-red-500 text-black hover:text-white text-md font-bold"
    >Ordenar productos</button>
</form>