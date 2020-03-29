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
            'freeCards' => $this->freeCards,
            'step' => $this->step,
            'players' => $this->players->sortBy('name')->values(),
            'is_full' => $this->is_full,
            'step_started_at' => $this->step_started_at,
        ];
    }
}
