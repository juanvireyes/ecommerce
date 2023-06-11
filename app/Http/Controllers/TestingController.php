<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Builders\GeneralRequestBuilder;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Actions\UpdateProductStatusAction;
use App\Http\Requests\StoreCartItemRequest;
use App\Repositories\SubcategoryRepository;
use App\Services\ExchangeCurrencyService;
use Illuminate\Database\Eloquent\Casts\Json;

class TestingController extends Controller
{
    private ProductRepository $productRepository;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    // public function index(Request $request): View
    // {
    //     $products = $this->loadProducts();

    //     return view('testing', compact('products'));
    // }

    // public function loadProducts(): JsonResponse
    // {
    //     $products = $this->productRepository->getAllProducts();

    //     return response()->json($products);
    // }

    // public function updateAllProducts(UpdateProductStatusAction $action)
    // {
    //     return $action->execute();
    // }

    public function index(): View
    {
        $fromCurrency = 'COP';
        $toCurrency = 'USD';
        $ammount = 350000;

        $response = new ExchangeCurrencyService();

        $response = $response->exchange($fromCurrency, $toCurrency, $ammount);

        return view('testing.testing-index', compact('response'));
    }

    public function showCartContentTest()
    {
        $user = auth()->user();

        if(!$user) {

            return view('auth.login');

        } else {

            $cart = $user->cart;
            
            $cartItems = collect($cart->cartItems)->groupBy('product_id')->map(function ($items) {
                $item = $items->first();
                $item->quantity = $items->sum('quantity');
                $item->item_total_amount = $items->sum('item_total_amount');
                return $item;
            });

            return view('testing.testing-cart', compact('cartItems', 'cart'));
        };

    }

    public function addToCartTest(Request $request, ProductRepository $productRepository)
    {
        $validated = $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $validated['product_id'];
        $quantity = $validated['quantity'];
        $product = $this->productRepository->getProductById($productId);
        
        $userId = auth()->id();

        if (!$userId) {
            return view('auth.login');
        } else {
            $cart = Cart::firstOrCreate([
                'user_id' => $userId
            ]);
            
            $cartItem = CartItemController::store($cart, $product, $quantity);

            $cart->calculateCartTotalAmountTest();

            return redirect()->route('cart.index');
        };
    }


    public function clearCartTest(Cart $cart): RedirectResponse
    {
        $cart->cartItems()->delete();
        $cart->total_amount = 0;
        $cart->save();

        return redirect()->route('cart.index');
    }
}
