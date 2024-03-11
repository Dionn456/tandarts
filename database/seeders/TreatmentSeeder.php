<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Treatment;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Treatment::truncate();

        $treatments = (array) [
            (object) ["name" => "Periodieke controle", "duration" => "10", "price" => "50"],
            (object) ["name" => "Vulling", "duration" => "20", "price" => "85"],
            (object) ["name" => "Wortelkanaalbehandeling", "duration" => "40", "price" => "250"],
            (object) ["name" => "Kroon", "duration" => "60", "price" => "750"],
            (object) ["name" => "Brug", "duration" => "60", "price" => "860"],
            (object) ["name" => "Implantaten", "duration" => "60", "price" => "1750"],
            (object) ["name" => "Tandextractie", "duration" => "20", "price" => "125"],
            (object) ["name" => "Gebitsreiniging", "duration" => "30", "price" => "85"],
            (object) ["name" => "Tanden bleken", "duration" => "60", "price" => "220"],
            (object) ["name" => "Beugel/Orthodontie", "duration" => "60", "price" => "2500"],

        ];

        foreach ($treatments as $treatment) {
            $db_treatment = new Treatment;
            $db_treatment->name = $treatment->name;
            $db_treatment->duration = $treatment->duration;
            $db_treatment->price = $treatment->price;
            $db_treatment->save();
        }
    }
}
