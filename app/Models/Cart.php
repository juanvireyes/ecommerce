<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property bool $completed
 * @property string $completed_at
 * @property float $total_amount
 * @property float $discount_amount
 * @property string $shipping_method
 * @property float $shipping_cost
 * @property string $billing_address
 * @property string $expires_at
 * @property User $user
 * @property CartItem[] $cartItems
 * @property float $total_amount_test
 */
class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'completed',
        'completed_at',
        'total_amount',
        'discount_amount',
        'shipping_method',
        'shipping_cost',
        'billing_address',
        'expires_at',
    ];

    protected $dates = [
        'expires_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function calculateCartTotalAmountTest(): float
    {
        $cartItems = $this->cartItems;
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $totalAmount += $item->quantity * $item->price;
        };

        $this->total_amount = $totalAmount;
        $this->save();

        return $this->total_amount;
    }

    public function clearCart(): self
    {
        $cartItems = $this->cartItems;

        foreach ($cartItems as $cartItem) {
            $cartItem->load('product');
            $product = $cartItem->product;
            $quantity = $cartItem->quantity;
            $product->increaseStock($quantity);
            $product->updateStatus();
        };
        
        $this->cartItems()->delete();
        $this->total_amount = 0;
        $this->save();

        return $this;
    }
}
