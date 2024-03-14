<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUser extends Model
{
    use HasFactory;

    protected $with = [
        'user',
        'role'
    ];

    public function belong_user()
    {
        return $this->belongsTo(User::class, "id", "user_id");
    }

    public function role()
    {
        return $this->hasOne(Role::class, "id", "role_id");
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", "link_user_id");
    }
}
