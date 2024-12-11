<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'isActive',
    ];

    /**
     * Get the subcategories for the product category.
     */
    public function subcategories()
    {
        return $this->hasMany(ProductSubCategory::class, 'category_id');
    }
}
