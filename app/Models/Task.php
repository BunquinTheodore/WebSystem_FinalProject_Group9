<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'type',        // opening | closing
        'location_id',
        'active',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function checklistItems()
    {
        return $this->hasMany(TaskChecklistItem::class)->orderBy('display_order');
    }
}