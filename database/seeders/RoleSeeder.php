<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $roles = (array) [
            (object) ["name" => "Admin"],
            (object) ["name" => "Tandarts"],
            (object) ["name" => "Tandarts Assistent"],
            (object) ["name" => "Patient"]
        ];

        foreach ($roles as $role) {
            $db_role = new Role;
            $db_role->name = $role->name;
            $db_role->save();
        }
    }
}
