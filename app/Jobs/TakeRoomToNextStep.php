<?php


namespace App\Jobs;


use App\Events\RoomUpdated;
use App\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TakeRoomToNextStep implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->room->next();

        event(new RoomUpdated($this->room));

        if ($this->room->step != Room::STEP_DAY) {
            TakeRoomToNextStep::dispatch($this->room)->delay(now()->addSecond(20));
        }
    }

}
