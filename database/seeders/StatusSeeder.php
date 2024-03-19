<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::truncate();

        $statuses = (array) [
            (object) ["code" => "open", "name" => "Open", "color" => "Green"],
            (object) ["code" => "invoiced", "name" => "Factuur verzonden", "color" => "Purple"],
            (object) ["code" => "closed", "name" => "Gesloten", "color" => "Red"],
        ];

        foreach ($statuses as $status) {
            $db_status = new Status;
            $db_status->code = $status->code;
            $db_status->name = $status->name;
            $db_status->color = $status->color;
            $db_status->save();
        }
    }
}
