<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewRequest extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $message;
    protected $redirect;

    public function __construct($message, $redirect)
    {
        $this->message = $message;
        $this->redirect = $redirect;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'redirect' => $this->redirect,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $data = [
            'message' => $this->message,
            'redirect' => $this->redirect,
        ];

        return (new BroadcastMessage($data))
                   ->onConnection('database')      // Set the queue connection
                   ->onQueue('broadcasts');  // Set the queue name
    }
}
