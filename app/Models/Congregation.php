<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congregation extends Model
{
    use HasFactory;

    protected $fillabke = [
        'name'
    ];

    /**
     * Get all of the stands for the Congregation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stands(): HasMany
    {
        return $this->hasMany(Stand::class, 'stand_id', 'id');
    }
}
