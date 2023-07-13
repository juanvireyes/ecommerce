<form action="{{ route('rep.products.export') }}" method="get" class="mt-3">
    <label for="sortProducts" class="text-red-500 text-center text-md font-bold m-auto">
        Ordenar productos para descarga
    </label>

    <select name="sortProducts" class="w-4/6 text-red-500 font-bold">
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
            class="bg-blue-500 btn btn-primary px-3 py-3 text-white font-semibold text-sm rounded-md ml-2 mt-3"
    >
        Descargar reporte filtrado
    </button>
</form>
