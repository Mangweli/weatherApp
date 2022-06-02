<?php

namespace App\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DailyForecastEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $feelLike;
    public $temp;
    public $weather;
    public $cityId;
    public $dailyForecastID;
    public $date;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($feelLike, $temp, $weather, $cityId, $dailyForecastID, $date)
    {
        $this->feelLike        = $feelLike;
        $this->temp            = $temp;
        $this->weather         = $weather;
        $this->cityId          = $cityId;
        $this->dailyForecastID = $dailyForecastID;
        $this->date            = $date;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
