<?php

namespace App\Models;


use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getTotalAttribute(): float
    {
        $orderItem = $this->orderItems;
        $total = 0;

        foreach ($orderItem as $item) {
            $total += $item->price * $item->quantity;
        };

        return $total;
    }
}
