<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_type'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
