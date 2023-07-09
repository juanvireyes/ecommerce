<?php

namespace App\Models;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $image
 * @property int $order
 * @property mixed $subcategories
 */
class Category extends Model
{
    use HasFactory;

//    public mixed $subcategories;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'order'
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }

}
