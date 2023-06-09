<?php

namespace App\Models;


use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property float $total
 * @property string $order_number
 * @property string $url
 * @property string $currency
 * @property string $status
 * @property User $user
 * @property OrderDetail[] $orderItems
 * @property string $created_at
 * @property string $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'order_number',
        'url',
        'currency',
        'status',

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

    public function completed(): void
    {
        $this->update([
            'status' => 'completed'
        ]);
    }

    public function approved(): void
    {
        $this->update([
            'status' => 'approved'
        ]);
    }

    public function cancelled(): void
    {
        $this->update([
            'status' => 'cancelled'
        ]);
    }

    public function rejected(): void
    {
        $this->update([
            'status' => 'rejected'
        ]);
    }


}
