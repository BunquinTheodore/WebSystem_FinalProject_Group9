<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'title',
        'thumbnail_path',
        'video_url',
        'description',
        'duration_sec',
    ];
}