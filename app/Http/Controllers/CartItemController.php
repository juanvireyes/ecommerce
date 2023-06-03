<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateCartItemRequest;
use Illuminate\Validation\ValidationException;

class CartItemController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public static function store(int $productId, int $quantity): JsonResponse
    {
        // $cart = new Cart();
        $cartId = Session::get('cart_id');

        // $cart = $cartId ? Cart::find($cartId) : new Cart();

        if(!$cartId) {
            $cart = Cart::create();
            $cartId = Session::put('cart_id', $cart->id);
            dd($cart->id);
        };

        $cartItem = new CartItem();

        $existingCartItem = $cartItem->product()->where('id', $productId)->first();

        if($existingCartItem) {

            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();

        } else {

            $product = Product::find($productId);

            if(!$product) {
                throw new ValidationException('Product not found');
            };

            CartItem::create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        };

        return response()->json([
            'message' => 'Producto agregado exitosamente',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $product = $cartItem->product;

        $validated  = $request->validated();

        $product->update($validated);

        return response()->json([
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json([
            'data' => 'Producto eliminado exitosamente',
        ]);
    }
}
