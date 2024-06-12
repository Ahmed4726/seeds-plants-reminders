<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['task_id', 'tag'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
