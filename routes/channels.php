<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    \Log::debug('App.User.{id}');
    return (int)$user->id === (int)$id;
});

Broadcast::channel('room.{room}', function ($user, $room) {

    if ($room->is($user->room)) {
        return ['name' => $user->name];
    }
    return false;

});
