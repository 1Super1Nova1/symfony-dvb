<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patients;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model
{
    protected $table = "Treatment";

    protected $fillable = [
        "name"
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Patients::class);
    }
}