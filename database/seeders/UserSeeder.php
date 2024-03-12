<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = (array) [
            (object) ["firstname" => "Jan ", "lastname" => "Vries", "email" => "jan@vries.nl", "phone" => "0612321221", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/jan.jpg", "role_id" => "2"],
            (object) ["firstname" => "Pieter ", "lastname" => "Bergen", "email" => "pieter@bergen.nl", "phone" => "0601929301", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/pieter.jpg", "role_id" => "2"],
            (object) ["firstname" => "Erik ", "lastname" => "Dijken", "email" => "erik@dijken.nl", "phone" => "0691828381", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/erik.jpg", "role_id" => "2"],
            (object) ["firstname" => "Koen ", "lastname" => "Leeuwen", "email" => "koen@leeuwen.nl", "phone" => "0661728391", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/koes.jpg", "role_id" => "2"],
            (object) ["firstname" => "Petra ", "lastname" => "Bakker", "email" => "petra@bakker.nl", "phone" => "0661728394", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/petra.jpg", "role_id" => "3"],
            (object) ["firstname" => "Anneke ", "lastname" => "Jansen", "email" => "anneke@jansen.nl", "phone" => "0681928381", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/anneke.jpg", "role_id" => "3"],
            (object) ["firstname" => "Marloes ", "lastname" => "Jacobs", "email" => "marloes@jacobs.nl", "phone" => "0691827173", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/marloes.jpg", "role_id" => "3"],
            (object) ["firstname" => "Sophie ", "lastname" => "Boer", "email" => "sophie@boer.nl", "phone" => "0682910391", "birth_date" => "2024-03-11 11:38:51", "password" => Hash::make('test'), "image_url" => "img/sophie.jpg", "role_id" => "3"]
        ];

        foreach ($users as $user) {
            $db_user = new User;
            $db_user->firstname = $user->firstname;
            $db_user->lastname = $user->lastname;
            $db_user->email = $user->email;
            $db_user->phone = $user->phone;
            $db_user->birth_date = $user->birth_date;
            $db_user->password = $user->password;
            $db_user->image_url = $user->image_url;
            $db_user->role_id = $user->role_id;
            $db_user->save();
        }
    }
}
