<?php


namespace App\Http\Controllers;


use App\Events\RoomUpdated;
use App\Resources\RoomResource;
use App\Room;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use function Psy\debug;

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
        $alreadyFull = $room->is_full;
        \Auth::login($user);
        $user->update(['is_connected' => true]);

        if (!$alreadyFull && $room->is_full) {
            $room->drawCards();
            $room->step = Room::STEP_READY;
            $room->save();
            $room->refresh();
        }

        event(new RoomUpdated($room));

        return response()->json(['success' => true, 'user' => $user, 'room' => new RoomResource($room)]);
    }

    public function reset(Request $request, Room $room)
    {

        $room->reset();
        $room->drawCards();
        $room->step = Room::STEP_READY;
        $room->save();
        $room->refresh();


        event(new RoomUpdated($room));

        return response()->json(['success' => true]);
    }


    public function fallAsleep(Request $request, Room $room, User $user)
    {
        $user->is_sleeping = true;
        $user->save();

        $room->start();

        event(new RoomUpdated($room->refresh()));

        return response()->json(['success' => true]);
    }

    public function doAction(Request $request, Room $room, User $user)
    {
        if ($request->role === Room::ROLE_VOLEUR) {
            $otherPlayer = User::find($request->stealedPlayerId);
            $otherPlayer->current_role = $user->original_role;
            $user->current_role = $otherPlayer->original_role;

            $otherPlayer->save();
            $user->save();
        }

        if ($request->role === Room::ROLE_NOISEUSE) {
            $player1 = User::find($request->player1Id);
            $role1 = $player1->current_role;

            $player2 = User::find($request->player2Id);
            $role2 = $player1->current_role;

            $player1->current_role = $role2;
            $player2->current_role = $role1;

            $player1->save();
            $player2->save();
        }

        event(new RoomUpdated($room->refresh()));

        return response()->json(['success' => true]);
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function showRoom(Room $room)
    {
        return view('room', ['room' => $room]);
    }

    public function getRoom(Room $room)
    {
        return new RoomResource($room);
    }
}
