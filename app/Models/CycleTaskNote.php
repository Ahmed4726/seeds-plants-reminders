<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleTaskNote extends Model
{
    use HasFactory;

    protected $table = 'cycletask_notes';

    protected $fillable = [
        'note',
    ];

    public function task()
    {
        return $this->belongsTo(CycleTask::class);
    }
}
