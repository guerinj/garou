<?php


namespace App\Http\Controllers;


use App\Resources\RoomResource;
use App\Room;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RoomController extends Controller
{

    public function createRoom(Request $request)
    {
        $validated = $this->validate($request, [
            'players' => 'required',
            'players.*.name' => 'required|string|max:255',
            'roles' => 'required',
        ]);

        $room = Room::factory($request->only('roles'));
        $room->save();

        $room->players()->createMany($request->players);
        return new RoomResource($room);
    }

    public function joinRoom(Request $request, Room $room, User $user)
    {
        \Auth::login($user);
        $user->session_id = \Session::getId();
        $user->save();

        return response()->json(['success' => true]);
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function getRoom(Room $room)
    {
        return new RoomResource($room);
    }
}
