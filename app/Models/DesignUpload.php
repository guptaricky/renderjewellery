<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignUpload extends Model
{
    use HasFactory;

    // Specify the table name (not required if it follows Laravel's naming convention)
    protected $table = 'design_upload';

    // Define the mass-assignable attributes
    protected $fillable = [
        'user_id',
        'description',
        'design_count'
    ];

    // Disable timestamps if not required (optional)
    // public $timestamps = false;
}
