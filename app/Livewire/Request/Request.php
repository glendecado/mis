<?php

namespace App\Livewire\Request;

use App\Events\RequestEventMis;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Database\Seeders\Faculty;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\MountManager;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class Request extends Component
{
    public $faculty_id;


    public function mount()
    {

        $this->faculty_id = Auth::user()->id;
 
    
    }


    #[On('echo-private:NewRequest.{faculty_id},RequestEventMis')]
    public function request_event($e)
    {

      $this->dispatch('success', name: $e['notifMessage']);  
      $this->dispatch('update-request');
   
    }






}
