<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $with = [
        'dentist', 'assistent', 'patient'
    ];

    public function dentist()
    {
        return $this->hasOne(AppointmentUser::class, "appointment_id", "id")->where('role_id', 2);
    }

    public function assistent()
    {
        return $this->hasOne(AppointmentUser::class, "appointment_id", "id")->where('role_id', 3);
    }

    public function patient()
    {
        return $this->hasOne(AppointmentUser::class, "appointment_id", "id")->where('role_id', 4);
    }
    
    // public function users()
    // {
    //     return $this->hasMany(AppointmentUser::class, "appointment_id", "id");
    // }
}
