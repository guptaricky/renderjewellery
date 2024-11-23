<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // Specify the table name (not required if it follows Laravel's naming convention)
    protected $table = 'images';

    // Define the mass-assignable attributes
    protected $fillable = [
        'file_name', 'image_data',
    ];

    // Disable timestamps if not required (optional)
    // public $timestamps = false;
}
