<div>
    @if ($product)
        <h1>Producto Agregado al Carrito:</h1>
        <p>{{ $product->name }}</p>
        <p>{{ $product->price }}</p>
        <!-- Aquí puedes mostrar más detalles del producto agregado al carrito -->
    @endif
</div>
