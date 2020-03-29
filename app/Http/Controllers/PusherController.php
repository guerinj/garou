<?php


namespace App\Http\Controllers;


use App\Events\RoomFull;
use App\Events\RoomUpdated;
use App\Resources\RoomResource;
use App\Room;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PusherController extends Controller
{

    /**
     * Accept a Webhook event
     *
     * @param string $webhook
     * @return response
     */
    public function webhooks(Request $request)
    {
        \Log::debug($request->all());

        foreach ($request->events as $event) {
            if ($event['name'] === 'member_added') {
                $this->handleMemberAdded($event);
            } else if ($event['name'] === 'member_added') {
                $this->handleMemberRemoved($event);
            }
        }

    }

    private function handleMemberAdded($event)
    {
        $user = User::find($event['user_id']);
        $user->update(['is_connected' => true]);

        $room = Room::where('code', explode('.', $event['channel'])[1])->first();

        event(new RoomUpdated($room));

    }

    private function handleMemberRemoved($event)
    {
        $user = User::find($event['user_id']);
        $user->update(['is_connected' => false]);
    }
}
