@extends('reports.index')

@section('table')

    @include('products.partials.session-messages')

    @include('reports.partials.products-sort')

    <div class="flex justify-between">
        @include('reports.partials.export-button')
    </div>

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
                    Disponible
                </th>
                <th scope="col"
                    class="mx-4 px-4 uppercase text-red-500 font-semibold border border-slate-300">
                    Total unidades vendidas
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($registers as $register)
                <tr class="text-center">
                    <td class="border border-slate-300 py-4">
                        {{ $register->products->name }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        {{ $register->products->description }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        {{ $register->products->price }}
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        @if($register->products->active == 1)
                            Si
                        @else
                            No
                        @endif
                    </td>
                    <td class="border border-slate-300 py-4 px-2">
                        {{ $register->sold_units }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $registers->links() }}
    </div>
@endsection

