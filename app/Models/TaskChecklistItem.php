<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskChecklistItem extends Model
{
    protected $fillable = [
        'task_id',
        'label',
        'display_order',
        'is_required',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}