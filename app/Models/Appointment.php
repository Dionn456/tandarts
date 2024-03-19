<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $with = [
        'dentist', 'assistent', 'patient', 'room', 'status', "treatments"
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

    public function room()
    {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function treatments()
    {
        return $this->hasMany(AppointmentTreatment::class, 'appointment_id', 'id');
    }


    
    // public function users()
    // {
    //     return $this->hasMany(AppointmentUser::class, "appointment_id", "id");
    // }
}
