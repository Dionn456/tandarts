<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::truncate();

        $rooms = (array) [
            (object) ["name" => "Kamer 1", "floor" => 1, "number" => 1],
        ];

        foreach ($rooms as $room) {
            $db_room = new Room;
            $db_room->name = $room->name;
            $db_room->floor = $room->floor;
            $db_room->number = $room->number;
            $db_room->save();
        }
    }
}
