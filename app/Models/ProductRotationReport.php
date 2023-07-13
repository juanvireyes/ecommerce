<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *@property int $id
 *@property int $product_id
 *@property int $sold_units
 */
class ProductRotationReport extends Model
{
    use HasFactory;

    protected $fillable = [
      'product_id',
      'sold_units'
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function increaseSoldUnits(int $quantity): int
    {
        $this->sold_units += $quantity;

        $this->save();

        return $this->sold_units;
    }
}
