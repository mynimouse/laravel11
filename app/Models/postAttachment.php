<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class postAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_path', 'post_id'
    ];
}
