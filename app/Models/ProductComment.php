<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;

    // Define the table name if it differs from the pluralized model name
    protected $table = 'product_comments';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
    ];

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
