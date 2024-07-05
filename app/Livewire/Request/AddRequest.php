<?php

namespace App\Livewire\Request;

use App\Events\RequestEventMis;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddRequest extends Component
{

    public $category;
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
                'category' => $this->category,
                'concerns' =>  $this->concerns,
                'status' => $this->status,
            ]
        );

        $req->save();


        RequestEventMis::dispatch($mis->id);

        $this->reset('category');
        $this->reset('concerns');
        $this->dispatch('update-request');
        $this->dispatch('success', name: 'Request successfully sent.');
    }
}
