<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Specify the table name (not required if it follows Laravel's naming convention)
    protected $table = 'products';

    // Define the mass-assignable attributes
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'short_description',
        'price',
        'category_id',
        'subcategory_id',
        'product_code',
        'designer_id',
        'weight',
        'dimensions',
        'design_count'
    ];

    // Disable timestamps if not required (optional)
    // public $timestamps = false;

    public function productdesign()
    {
        return $this->hasMany(ProductDesign::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'product_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'subcategory_id');
    }
}
