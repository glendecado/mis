<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class NotifEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */




     public $count;

    public function __construct(
        public $notifMessage = 'sdf',
        public int $reciever
    ) {

        $userNotifCount = 'notif-count' .   $reciever;
        if (Cache::has($userNotifCount)) {

            Cache::increment($userNotifCount);
        } else {
            Cache::put($userNotifCount, 1, now()->addDays(10));
        }

        $this->count =  Cache::get($userNotifCount);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('Notif.' . $this->reciever);
    }
}
