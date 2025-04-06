<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Doctors;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $table = "Schedule";

    protected $fillable = [
        "name"
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Doctors::class);
    }
}