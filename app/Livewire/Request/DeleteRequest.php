<?php

namespace App\Livewire\Request;

use App\Events\RequestEventMis;
use App\Models\Request;
use App\Models\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class DeleteRequest extends Component
{
    #[On('request-delete')]
    public function deleteRequest($id)
    {
        //check faculty
    
        Cache::forget('request-for-faculty');
        //check mis
        $mis = User::where('role', 'Mis Staff')->first();

        try {
            $req = Request::find($id);

            $req->delete();
            $this->dispatch('success', name: 'Request Deleted Successfully');
        } catch (Throwable $e) {
            $this->dispatch('error', name: 'Something went wrong');
        }
        if (Auth::user()->role === 'Mis Staff') {

            RequestEventMis::dispatch($req->faculty_id);
        } else {
            RequestEventMis::dispatch($mis->id);
        }



        return redirect()->to('/request');
       

    }

}
