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
        return $this->belongsTo(Product::class);
    }
}
