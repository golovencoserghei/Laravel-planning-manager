<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StandPublishers extends Model
{
    use HasFactory;

    protected $table = 'stands_publishers';

    protected $guarded = ['*'];

    /**
     * Get all of the standTemplates for the StandPublishers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function standTemplates(): HasMany
    {
        return $this->hasMany(StandTemplate::class, 'id', 'stand_template_id');
    }

    /**
     * Get the user associated with the StandPublishers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_1');
    }

    /**
     * Get the user associated with the StandPublishers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user2(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_2');
    }
}
