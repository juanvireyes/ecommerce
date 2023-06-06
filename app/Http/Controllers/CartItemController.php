<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateCartItemRequest;

class CartItemController extends Controller
{

    public static function store(Cart $cart, Product $product, int $quantity): CartItem
    {
        $cartId = $cart->id;
        $productId = $product->id;
        $productName = $product->name;
        $productPrice = $product->price;

        $cartItem = CartItem::Create([
            'cart_id' => $cartId,
            'product_id' => $productId,
            'product_name' => $productName,
            'quantity' => $quantity,
            'price' => $productPrice,
            'item_total_amount' => $product->price * $quantity,
        ]);

        return $cartItem;
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem): RedirectResponse
    {
        $cart = $cartItem->cart;

        $product = Product::find($cartItem->product_id);

        $validated = $request->validated();
        $quantity = $validated['quantity'];
        $actualAmount = $cartItem->price * $quantity;
        $actualQuantity = $cartItem->quantity;

        if($quantity < $cartItem->quantity) {

            $newQuantity = $actualQuantity - $quantity;
            
            $cartItem->quantity = $newQuantity;
            
            $newAmount = $actualAmount;
            
            $cartItem->item_total_amount = $newAmount;

            $product->increaseStock($newQuantity);

            $product->updateStatus();

        } elseif ($quantity > $cartItem->quantity) {

            $quantityDifference = $quantity - $actualQuantity;
            
            $newQuantity = $cartItem->quantity + $quantityDifference;
            
            $cartItem->quantity = $newQuantity;
            
            $newAmount = $actualAmount;
            
            $cartItem->item_total_amount = $newAmount;

            $product->reduceStock($newQuantity);

            $product->updateStatus();
        }

        
        $cartItem->save();

        $cart->total_amount = $cart->calculateCartTotalAmountTest();

        return back()->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem, Request $request)
    {
        $cart = $cartItem->cart;

        $cartItem->product->increaseStock($cartItem->quantity);

        $cartItem->product->updateStatus();

        $cartItem->delete();

        $cart->calculateCartTotalAmountTest();

        return back()->with('success', 'Producto eliminado exitosamente');
    }
}
