<form action="{{ route('reports.products') }}" method="get">
    <label for="sortProducts" class="text-red-500 text-center text-md font-bold m-auto px-2 py-2">
        Ordenar productos
    </label>

    <select name="sortProducts" class="w-2/6 text-red-500 font-bold">
        <option value=""></option>
        <option value="mostSelled" {{ $request->input('sortProducts') === 'mostSelled' ? 'selected' : '' }}
        class="text-red-500 font-bold">
            Más vendidos
        </option>
        <option value="lessSelled" {{ $request->input('sortProducts') === 'lessSelled' ? 'selected' : '' }}
        class="text-red-500 font-bold">
            Menos vendidos
        </option>
    </select>

    <button type="submit"
            class="bg-blue-500 btn btn-primary px-3 py-3 text-white font-semibold text-sm rounded-md ml-2"
    >
        Filtrar
    </button>
</form>
