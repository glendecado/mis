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

    public $count;
    public $notifData;
    public function __construct(
        public $notifMessage,
        public int $reciever
    ) {
        // Cache keys
        $userNotifCount = 'notif-count-' . $reciever;
        $userNotifMessage = 'notif-message-' . $reciever;

        // Handle notification count in cache
        if (Cache::has($userNotifCount)) {
            Cache::increment($userNotifCount);
        } else {
            Cache::put($userNotifCount, 1, now()->addDays(10));
        }

        // Create an associative array for the notification
        $this->notifData = [
            'message' => $this->notifMessage,
            'date' => now()->format('Y-m-d H:i:s') // Store current date and time
        ];

        // Handle notification messages in cache
        if (Cache::has($userNotifMessage)) {
            // Get existing messages and append the new associative array
            $existingMessages = Cache::get($userNotifMessage);
            $existingMessages[] = $this->notifData; // Append new notification with message and date
            Cache::put($userNotifMessage, $existingMessages, now()->addDays(10)); // Update cache
        } else {
            // Store the first message as an array of associative arrays
            Cache::put($userNotifMessage, [$this->notifData], now()->addDays(10));
        }

        // Retrieve the updated notification count
        $this->count = Cache::get($userNotifCount);
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('Notif.' . $this->reciever);
    }
}
