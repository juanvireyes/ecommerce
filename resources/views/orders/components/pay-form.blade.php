<div>
    <form action="{{ route('orders.payment', $order->id) }}" method="post">
        @csrf

        <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">

        <button type="submit">Pagar</button>
    </form>
</div>