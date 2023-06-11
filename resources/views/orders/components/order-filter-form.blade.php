<div class="mt-4 mx-auto text-center">
    <form action="{{ route('orders.index') }}" method="get">
        @csrf

        <label for="filter_orders" class="text-red-600 text-md font-bold mr-2 px-auto">
            Selecciona el estado de la orden:
        </label>

        <select name="filter_orders" id="filter_orders" 
        class="ml-1 mr-2 px-2 text-red-600 text-md font-semibold">
            <option value="">Todas las órdenes</option>
            <option value="pending">Pendientes</option>
            <option value="completed">Completos</option>
            <option value="approved">Aprobados - Pendientes de pago</option>
            <option value="cancelled">Cancelados</option>
            <option value="rejected">Rechazados</option>
        </select>

        <button type="submit" class="bg-red-600 text-white text-sm font-semibold px-3 py-2 rounded-md">
            Filtrar
        </button>
    </form>
</div>