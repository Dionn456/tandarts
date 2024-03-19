<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTreatment extends Model
{
    use HasFactory;

    protected $with = [
        'treatment'
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, "treatment_id", "id");
    }
}
