<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repositories\ProductRepository;
use App\Http\Requests\StoreCartItemRequest;

class CartController extends Controller
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    

    public function index(): View
    {
        $user = auth()->user();

        if(!$user) {

            return view('auth.login');

        } else {

            $cart = $user->cart;
            
            $cartItems = $cart->cartItems->groupBy('product_id')->map(function ($items) {
                $item = $items->first();
                $item->quantity = $items->sum('quantity');
                $item->item_total_amount = $items->sum('item_total_amount');
                return $item;
            });

            return view('cart.index', compact('cartItems', 'cart'));
        };
    }

    
    
    public function addToCart(StoreCartItemRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $productId = $validated['productId'];
        $quantity = $validated['quantity'];

        $product = $this->productRepository->getProductById($productId);

        $userId = auth()->id();

        if(!$userId) {

            return redirect()->route('login');

        } else {

            $cart = Cart::firstOrCreate([
                'user_id' => $userId
            ]);
            
            $cartItem = CartItemController::store($cart, $product, $quantity);

            try {
                $product->reduceStock($quantity);
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            };

            $product->updateStatus();

            if ($cartItem) {

                $cart->calculateCartTotalAmountTest();

                return back()->with('success', 'Producto agregado al carrito');

            } else {

                return back()->with('error', 'Error al agregar el producto al carrito');

            };
        };

    }

    
    public function clearCart(Cart $cart): RedirectResponse
    {
        $cartItems = $cart->cartItems;

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $quantity = $cartItem->quantity;
            $product->increaseStock($quantity);
            $product->updateStatus();
        };
        
        $cart->cartItems()->delete();
        $cart->total_amount = 0;
        $cart->save();

        return redirect()->route('cart.index');
    }
}
