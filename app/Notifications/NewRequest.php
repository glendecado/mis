<?php

namespace App\Notifications;

use App\Models\Request;
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

    protected $img;
    protected $name;
    protected $concerns;
    protected $date;
    protected $message;
    protected $redirect;
    protected $reqId;

    public function __construct(Request $request)
    {

        $this->name = session('user')['name'];
        $this->img = session('user')['img'];
        $this->date = $request->created_at;
        $this->concerns = $request->concerns;
        $this->redirect = '/request/'.$request->id;
        $this->reqId = $request->id;
        

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

 
    public function toDatabase(object $notifiable)
    {
        return [
            'req_id' => $this->reqId,
            'message' => $this->message,
            'name' => $this->name ,
            'img' => $this->img,
            'date' => $this->date,
            'concerns' => $this->concerns,
            'redirect' => $this->redirect 


        ];
    }
   
    public function toBroadcast(object $notifiable): BroadcastMessage
    {

        
     
        
        
        return new BroadcastMessage([
            'req_id' => $this->reqId,
            'message' => $this->message,
            'name' => $this->name ,
            'img' => $this->img,
            'date' => $this->date,
            'concerns' => $this->concerns,
            'redirect' => $this->redirect
        ]);

    }
}
