<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreCartItemRequest;
use App\Repositories\ProductRepository;
use Barryvdh\Debugbar\Facade;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = FacadesCart::content();

        foreach ($cartItems as $cartItem) {
            
            $cartItem->itemTotal = $cartItem->price * $cartItem->qty;
        }

        $cartItems->total = FacadesCart::subtotal();

        // dd($cartItems);

        return view('cart.index', compact('cartItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addToCart(StoreCartItemRequest $request)
    {
        $validated = $request->validated();

        $product = $this->productRepository->getProductById($validated['productId']);

        $cart = FacadesCart::add($product->id, $product->name, $validated['quantity'], $product->price);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
