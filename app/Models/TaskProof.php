<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskProof extends Model
{
    protected $fillable = [
        'task_assignment_id',
        'photo_path',
        'qr_payload',
        'captured_at',
        'notes',
    ];

    protected $casts = [
        'captured_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(TaskAssignment::class, 'task_assignment_id');
    }
}