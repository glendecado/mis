<?php

namespace App\Livewire\Request;

use App\Models\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
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

    $this->dispatch('success', name: $e['notifMessage']);
    $this->dispatch('update-request');
  }


  #[On('update-request')]
  public function render()
  {
    $faculty_id = Auth::user()->id;
    $t = Task::where('technicalStaff_id', Auth::id());
    $r = $t->pluck('request_id')->unique();

   

    if (Auth::user()->role == 'Faculty') {
      return view('livewire.request.view-request', ['request' => Request::where('faculty_id', $faculty_id)->with('faculty')->get()]);
    }
    if (Auth::user()->role == 'Mis Staff') {
      return view('livewire.request.view-request', ['request' => Request::with('faculty')->get()]);
    }

    if (Auth::user()->role == 'Technical Staff') {
      return view('livewire.request.view-request', ['request' => Request::whereIn('id', $r)->get()]);
    }


  }
}
