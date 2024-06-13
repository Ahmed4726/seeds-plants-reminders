<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleTask extends Model
{
    use HasFactory;

    protected $table = 'cycletasks';

    protected $fillable = [
        'name',
        'days_from_start',
        'reminder',
    ];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class, 'cycle_id');
    }

    public function notes()
    {
        return $this->hasMany(CycleTaskNote::class);
    }

    public function tags()
    {
        return $this->hasMany(CycleTaskTag::class);
    }
}
