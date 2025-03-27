<?php

namespace App\Notifications;

use App\Models\Categories;
use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssingedRequest extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     protected $img;
     protected $name;
     protected $date;
     protected $redirect;
     protected $category;
     protected $reqId;

    public function __construct(Request $request)
    {
        $user = User::find($request->faculty_id);
        $categories = Categories::where('request_id', $request->id)->get();
        $id = $categories->whereNotNull('category_id')->pluck('category_id')->toArray();
        $category = Category::whereIn('id', $id)->pluck('name')->toArray();
        $this->category = implode(',', $category);
        $this->name = $user->name;
        $this->img = $user->img;
        $this->date = $request->created_at;
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
            'name' => $this->name ,
            'img' => $this->img,
            'date' => $this->date,
            'category' => $this->category,
            'redirect' => $this->redirect 


        ];
    }
   
    public function toBroadcast(object $notifiable): BroadcastMessage
    {

        
        
        return new BroadcastMessage([

            'req_id' => $this->reqId,
            'name' => $this->name ,
            'img' => $this->img,
            'date' => $this->date,
            'category' => $this->category,
            'redirect' => $this->redirect 

        ]);

    }
}
