<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designs extends Model
{
    use HasFactory;

    protected $fillable = [
        'design_upload_id',
        'file_name',
        'file_path',
        'mime_type'
    ];
}
