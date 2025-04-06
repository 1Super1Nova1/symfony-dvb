<?php

namespace App\Models;

use App\Models\Diagnoses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctors extends Model
{
    protected $table = "doctors";

    protected $fillable = [
        "firstName",
        "lastName"
    ];

    /**
     * @return HasMany
     */
    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnoses::class);
    }

}