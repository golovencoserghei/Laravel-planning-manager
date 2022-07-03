<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'day',
        'times_range',
        'stand_id',
        'congregation_id',
    ];

    protected $casts = [
        'times_range' => 'array'
    ];
}
