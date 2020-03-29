<?php

use App\Room;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $room = Room::factory([
            'code' => 'aaa',
            'roles' => $faker->randomElements(Room::ROLES, 6)
        ]);
        $room->save();
        $players = [
            'Marine',
            'Pol',
            'Julian',
        ];

        foreach ($players as $player) {
            $user = new User([
                'name' => $player,
                'room_id' => $room->id
            ]);
            $user->save();
        }


        $room = Room::factory([
            'code' => 'bbb',
            'roles' =>
                [
                  //  Room::ROLE_GAROU1,
                    Room::ROLE_GAROU2,
//                    Room::ROLE_SBIRE,
                    Room::ROLE_VOYANTE,
                    Room::ROLE_NOISEUSE,
                    Room::ROLE_INSOMNIAQUE,
                    Room::ROLE_VOLEUR,
                    Room::ROLE_MACON1,
                    Room::ROLE_MACON2,
                ],
            'freeCards' => [
                Room::ROLE_GAROU2,
                Room::ROLE_MACON1,
                Room::ROLE_MACON2,
            ],
            'step' => Room::STEP_WAITING
        ]);
        $room->save();

        $players = [
            'Marine' => Room::ROLE_NOISEUSE,
            'Pol' => Room::ROLE_VOLEUR,
            'Julian' => Room::ROLE_VOYANTE,
            'Quentin' => Room::ROLE_INSOMNIAQUE,
            //'Charlotte' => Room::ROLE_SBIRE,
            //'Mathilde' => Room::ROLE_GAROU1,
        ];

        foreach ($players as $player => $role) {
            $user = new User([
                'name' => $player,
                'original_role' => $role,
                'current_role' => $role,
                'room_id' => $room->id
            ]);
            $user->save();
        }
    }
}
