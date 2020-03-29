<?php


namespace App;

use App\Events\RoomUpdated;
use App\Jobs\TakeRoomToNextStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Room extends Model
{

    public const ROLE_GAROU1 = 'ROLE_GAROU1';
    public const ROLE_GAROU2 = 'ROLE_GAROU2';
    public const ROLE_GAROU3 = 'ROLE_GAROU3';
    public const ROLE_SBIRE = 'ROLE_SBIRE';
    public const ROLE_VOYANTE = 'ROLE_VOYANTE';
    public const ROLE_NOISEUSE = 'ROLE_NOISEUSE';
    public const ROLE_VOLEUR = 'ROLE_VOLEUR';
    public const ROLE_MACON1 = 'ROLE_MACON1';
    public const ROLE_MACON2 = 'ROLE_MACON2';
    public const ROLE_INSOMNIAQUE = 'ROLE_INSOMNIAQUE';
    public const ROLE_SOULARD = 'ROLE_SOULARD';
    public const ROLES = [
        self::ROLE_GAROU1,
        self::ROLE_GAROU2,
        self::ROLE_GAROU3,
        self::ROLE_SBIRE,
        self::ROLE_VOYANTE,
        self::ROLE_NOISEUSE,
        self::ROLE_VOLEUR,
        self::ROLE_MACON1,
        self::ROLE_MACON2,
        self::ROLE_SOULARD,
    ];

    public const STEP_WAITING = 'STEP_WAITING';
    public const STEP_READY = 'STEP_READY';
    public const STEP_SOULARD = 'STEP_SOULARD';
    public const STEP_VOLEUR = 'STEP_VOLEUR';
    public const STEP_GAROU = 'STEP_GAROU';
    public const STEP_VOYANTE = 'STEP_VOYANTE';
    public const STEP_NOISEUSE = 'STEP_NOISEUSE';
    public const STEP_INSOMNIAQUE = 'STEP_INSOMNIAQUE';
    public const STEP_DAY = 'STEP_DAY';
    public const STEP_ = 'STEP_';

    protected $fillable = [
        'code',
        'roles'
    ];

    protected $casts = [
        'code' => 'string',
        'step' => 'string',
        'roles' => 'array',
        'freeCards' => 'array',
    ];

    public function getIsFullAttribute()
    {
        return $this->players()->get()->reduce(fn($allConnected, $u) => $allConnected && $u->is_connected, true);
    }

    public function getAllPlayersSleepingAttribute()
    {
        return $this->players()->get()->reduce(fn($allConnected, $u) => $allConnected && $u->is_sleeping, true);
    }

    public function reset()
    {
        $this->update([
            'freeCards' => null
        ]);

        $this->players()->update([
            'original_role' => null,
            'current_role' => null,
            'is_sleeping'=>false,
        ]);

        $this->refresh();
    }

    public function start()
    {
        if ($this->all_players_sleeping) {
            TakeRoomToNextStep::dispatch($this);
        }
    }

    public function next()
    {
        switch ($this->step) {
            case self::STEP_READY:
                $this->step = self::STEP_VOYANTE;
                break;
            case self::STEP_VOYANTE:
                $this->step = self::STEP_VOLEUR;
                break;
            case self::STEP_VOLEUR:
                $this->step = self::STEP_NOISEUSE;
                break;
            case self::STEP_NOISEUSE:
                $this->step = self::STEP_INSOMNIAQUE;
                break;
            case self::STEP_INSOMNIAQUE:
                $this->step = self::STEP_DAY;
                break;
        }

        $this->step_started_at = microtime(true);
        $this->save();
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function players()
    {
        return $this->hasMany(User::class);
    }

    public static function factory(array $data): Room
    {
        return new Room(
            array_merge(
                [
                    'step' => self::STEP_WAITING,
                    'code' => Room::generateCode(),
                    'freeCards' => [],
                ],
                $data
            )
        );
    }

    public static function generateCode()
    {
        return base_convert(str_replace('.', '', (string)microtime(true)), 10, 36);
    }

    public function drawCards()
    {
        /** @var Collection $roles */
        $roles = collect($this->roles)->shuffle();

        $mapper = fn($r) => ['original' => $r, 'current' => $r];

        $playersRoles = $roles->take($this->players->count())->toArray();
        $freeRoles = $roles->skip($this->players->count())->toArray();
        foreach ($this->players as $player) {
            $role = array_pop($playersRoles);
            $player->original_role = $role;
            $player->current_role = $role;
            $player->save();
        }
        $this->freeCards = $freeRoles;
        $this->step = self::STEP_READY;
        $this->save();

    }
}
