<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'qrcode_payload',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}