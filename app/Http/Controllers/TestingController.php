<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Actions\UpdateProductStatusAction;
use App\Http\Requests\StoreCartItemRequest;
use App\Repositories\SubcategoryRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\RedirectResponse;

class TestingController extends Controller
{
    private $subcategoryRepository;
    private ProductRepository $productRepository;
    private $categoriesRepository;
    private CartService $cartService;

    public function __construct(CategoryRepository $categoryRepository, SubcategoryRepository  $subcategoryRepository, ProductRepository $productRepository)
    {
        $this->categoriesRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
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
        $products = $this->productRepository->getAllProducts();

        return view('testing.testing-index', compact('products'));
    }

    public function showCartContentTest()
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

            // dd($cartItem);

            if ($cartItem) {

                $cart->calculateCartTotalAmountTest();

                return redirect()->route('cart.index');
            } else {
                return back()->with('error', 'Something went wrong');
            };
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
