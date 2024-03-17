<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentUser extends Model
{
    use HasFactory;

    protected $with = [
        'user',
        'role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function role()
    {
        return $this->hasOne(Role::class, "id", "role_id");
    }
}
