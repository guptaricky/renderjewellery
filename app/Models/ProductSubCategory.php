<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    use HasFactory;

    protected $table = 'product_subcategories';

    protected $fillable = [
        'category_id',
        'name',
        'code',
        'isActive',
    ];

    /**
     * Get the category that owns the subcategory.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
