<?php

namespace App\Livewire\Request;

use App\Models\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;


class ViewRequest extends Component
{
  public $faculty_id;


  public function mount()
  {

    $this->faculty_id = Auth::user()->id;
  }

  #[On('echo-private:NewRequest.{faculty_id},RequestEventMis')]
  public function request_event($e)
  {

    if (!is_null($e['notifMessage'])) {
    }

    $this->dispatch('update-request');
  }


  #[On('update-request')]
  public function render()
  {
    $user_id = Auth::id();


    $task = Task::where('technicalStaff_id', Auth::id());
    $Task_RequestId = $task->pluck('request_id')->unique();



    if (Auth::user()->role == 'Faculty') {
      return view('livewire.request.view-request', ['request' => Request::where('faculty_id', $user_id)->with('faculty')->get()]);
    }
    if (Auth::user()->role == 'Mis Staff') {
      return view('livewire.request.view-request', ['request' => Request::with('faculty')->get()]);
    }

    if (Auth::user()->role == 'Technical Staff') {
      return view('livewire.request.view-request', ['request' => Request::whereIn('id', $Task_RequestId)->get()]);
    }
  }
}
