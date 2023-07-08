<div class="mx-auto mt-6 px-4">
    <table class="table-auto border border-separate mx-auto w-full">
        <thead>
            <tr class="text-center">
                <th scope="col" 
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Nombre Producto
                </th>
                <th scope="col" 
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Descripción
                </th>
                <th scope="col" 
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Precio
                </th>
                <th scope="col" 
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Stock
                </th>
                <th scope="col" 
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Disponible
                </th>
                <th scope="col" 
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Orden en el display
                </th>
                <th scope="col"
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Subcategoría
                </th>
                <th scope="col" 
                class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="text-center">
                    <td class="border border-slate-300 py-4">
                        {{ $product->name }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        {{ $product->description }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        {{ $product->price }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        {{ $product->stock }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        {{ $product->active }}
                    </td>
                    <td class="border border-slate-300 py-4">
                        {{ $product->order }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        <a href="{{ route('subcategories.index') }}" 
                            class="text-gray-700 hover:text-red-500 text-sm font-bold">
                            {{ $product->subcategory->name }}
                        </a>
                    </td>
                    <td class="border border-slate-300 py-4">
                        <div class="flex justify-items-center">
                            <div class="mx-auto py-2 px-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 text-white text-sm font-bold rounded-full px-4 py-1">Editar</a>
                            </div>
                            <div class="mx-auto py-2 px-2">
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        class="bg-yellow-300 text-medium font-bold hover:bg-black text-black hover:text-white rounded-full px-4">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div>
    {{ $products->links() }}
</div>