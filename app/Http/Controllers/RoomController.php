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
        if (!$room->players()->where('id', $user->id)->exists() || !$user->isUsable()) {
            throw new AuthorizationException();
        }

        \Auth::login($user);
        $user->session_id = $request->session()->getId();
        return response()->json(['success' => false]);
    }

    public function getRoom(Room $room)
    {
        return new RoomResource($room);
    }
}
