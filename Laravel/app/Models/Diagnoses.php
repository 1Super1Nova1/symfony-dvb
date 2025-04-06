<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patients;
use App\Models\Doctors;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diagnoses extends Model
{
    protected $table = "Diagnoses";

    protected $fillable = [
        "diagnosesName"
    ];

    /**
     * @return BelongsTo
     */

    public function patients(): BelongsTo
    {
        return $this->belongsTo(Patients::class, 'id');
    }

    /**
     * @return BelongsTo
     */

    public function doctors(): BelongsTo
    {
        return $this->belongsTo(Doctors::class, 'id');
    }
}