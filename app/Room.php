<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{

    protected $fillable = [
        'code',
        'roles'
    ];

    protected $casts = [
        'code' => 'string',
        'roles' => 'array'
    ];


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
            array_merge($data,
                [
                    'code' => Room::generateCode()
                ]
            )
        );
    }

    public static function generateCode()
    {
        return base_convert(str_replace('.', '', (string)microtime(true)), 10, 36);
    }
}
