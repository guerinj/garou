<?php


namespace App\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use function foo\func;

class RoomResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'roles' => $this->roles,
            'players' => $this->players->map(fn($u) => ['id' => $u->id, 'name' => $u->name]),
        ];
    }
}
