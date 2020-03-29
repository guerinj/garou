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

        $room = Room::factory([
            'code' => 'aaa',
            'roles' =>
                [
                    Room::ROLE_GAROU,
                    Room::ROLE_SBIRE,
                    Room::ROLE_VOLEUR,
                    Room::ROLE_VOYANTE,
                    Room::ROLE_INSOMNIAQUE,
                ],
            'freeCards' => [
            ],
            'step' => Room::STEP_WAITING,
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
                    Room::ROLE_GAROU,
                    Room::ROLE_GAROU,
                    Room::ROLE_SBIRE,
                    Room::ROLE_VOYANTE,
                    Room::ROLE_NOISEUSE,
                    Room::ROLE_INSOMNIAQUE,
                    Room::ROLE_VOLEUR,
                ],
            'freeCards' => [],
            'step' => Room::STEP_WAITING
        ]);
        $room->save();

        $players = [
            'Marine',
            'Pol',
            'Julian',
            'Charlotte',
        ];

        foreach ($players as $player) {
            $user = new User([
                'name' => $player,

                'room_id' => $room->id
            ]);
            $user->save();
        }


        $room = Room::factory([
            'code' => 'ccc',
            'roles' =>
                [
                    Room::ROLE_GAROU,
                    Room::ROLE_GAROU,
                    Room::ROLE_SBIRE,
                    Room::ROLE_VOYANTE,
                    Room::ROLE_NOISEUSE,
                    Room::ROLE_INSOMNIAQUE,
                    Room::ROLE_VOLEUR,
                    Room::ROLE_MACON,
                    Room::ROLE_MACON,
                ],
            'freeCards' => [],
            'step' => Room::STEP_WAITING
        ]);
        $room->save();

        $players = [
            'Marine',
            'Pol',
            'Julian',
            'Quentin',
            'Charlotte',
            'Mathilde',
        ];

        foreach ($players as $player) {
            $user = new User([
                'name' => $player,
                'room_id' => $room->id
            ]);
            $user->save();
        }
    }
}
