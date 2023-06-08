@if ($order->status == 'pending')

    <span class="text-red-500 uppercase font-bold">Pendiente</span>

@elseif ($order->status == 'completed')

    <span class="text-green-500 uppercase font-bold">Completado</span>

@elseif ($order->status == 'approved')

    <span class="text-yellow-700 uppercase font-bold">Pendiente de aprobación</span>

@elseif ($order->status == 'rejected')

    <span class="text-red-500 uppercase font-bold">Pago rechazado</span>

@elseif ($order->status == 'cancelled')

    <span class="text-red-500 uppercase font-bold">Pago cancelado</span>

@endif