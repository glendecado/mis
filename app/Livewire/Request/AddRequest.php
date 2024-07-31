<?php

namespace App\Livewire\Request;

use App\Events\RequestEventMis;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class AddRequest extends Component
{

    public $category = 'Computer/laptop/printer';
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

        $mis = User::where('role', 'Mis Staff')->first();

        $req = Request::create(
            [
                'faculty_id' => Auth::user()->id,
                'category' => $this->others ?? $this->category,
                'concerns' =>  $this->concerns,
                'status' => $this->status,
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
   
        RequestEventMis::dispatch('new request', $mis->id);


        $this->reset('category');
        $this->reset('concerns');
        $this->reset('others');
        $this->dispatch('success', name: 'Request successfully sent.');
        $this->dispatch('update-request');
        $this->dispatch('update-count');

    }

    // Method to reset validation errors
    #[On('reset-validation')]
    public function resetValidationErrors()
    {

        $this->resetErrorBag();
        $this->reset();
    }
}
