<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function calculateCartTotalAmountTest(): self
    {
        $cartItems = $this->cartItems;

        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $totalAmount += $item->quantity * $item->price;
        };

        $this->total_amount = $totalAmount;

        $this->save();

        return $this;
    }

    public function clearCart(): self
    {
        $cartItems = $this->cartItems;

        foreach ($cartItems as $cartItem) {
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
