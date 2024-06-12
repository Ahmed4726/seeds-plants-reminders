<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleTaskTag extends Model
{
    use HasFactory;

    protected $table = 'cycletask_tags';

    protected $fillable = [
        'tag',
    ];

    public function task()
    {
        return $this->belongsTo(CycleTask::class);
    }
}
