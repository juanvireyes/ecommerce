<?php

namespace App\Models;

use Exception;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $image
 * @property float $price
 * @property int $stock
 * @property bool $active
 * @property int $order
 * @property int $subcategory_id
 * @property-read Subcategory $subcategory
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'stock',
        'active',
        'order',
        'subcategory_id',
    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function reduceStock(int $quantity): self
    {
        if($quantity <= $this->stock) {

            $this->stock -= $quantity;
            $this->save();
            return $this;

        } else {

            throw new Exception('Stock insuficiente');

        }
    }

    public function increaseStock(int $quantity): self
    {
        $this->stock += $quantity;
        
        $this->save();
        
        return $this;
    }

    public function updateStatus(): self
    {
        if ($this->stock > 0) {
            $this->active = true;
        } elseif ($this->stock == 0) {
            $this->active = false;
        }

        $this->save();
        return $this;
    }
}
