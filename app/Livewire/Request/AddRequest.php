<?php

namespace App\Livewire\Request;

use App\Events\RequestEventMis;
use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class AddRequest extends Component
{

    public $category;
    public $others;
    public $concerns;
    public $status = 'waiting';
    public $request = [];
    protected $rules = [
        'category' => 'required|string|max:255',
        'concerns' => 'required|string',
        'status' => 'required|string|max:255',
    ];


    public function addRequest()
    {
        $this->validate();

        Cache::forget('request-for-faculty');

        $mis = User::where('role', 'Mis Staff')->first();

        if($this->others){
            $category = Category::create(['name' => $this->others]);
            $categoryId = $category->id;

        }else {
            $categoryId = $this->category;
        }

        $req = Request::create(
            [
                'faculty_id' => Auth::user()->id,
                'category_id' => $categoryId,
                'concerns' =>  $this->concerns,
                'status' => $this->status,
                'progress' => 0,
            ]
        );

        $req->save();

        // Define an array to store in the cache
        $notificationData = [
            'message' => 'Request added',
            'request_id' => $req->id,
            'user_id' => Auth::user()->id,
            'timestamp' => now(),
        ];

        // Retrieve the current notifications from the cache
        $currentNotifications = Cache::get('notif-' . $mis->id, []);

        // Append the new notification to the current notifications
        $currentNotifications[] = $notificationData;

        // Store the updated notifications back in the cache
        Cache::put('notif-' . $mis->id, $currentNotifications, now()->addDays(10));
   
        RequestEventMis::dispatch($mis->id);


        $this->reset('category');
        $this->reset('concerns');
        $this->reset('others');
        $this->dispatch('success', name: 'Request successfully sent.');
        $this->dispatch('view-request');
        $this->dispatch('update-count');
        $this->dispatch('close-modal', 'add-request-modal');    

    }

    // Method to reset validation errors
    #[On('reset-validation')]
    public function resetValidationErrors()
    {

        $this->resetErrorBag();
        $this->reset();
    }
}
