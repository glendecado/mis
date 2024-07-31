<?php

namespace App\Livewire\Request;

use App\Models\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class ViewRequest extends Component
{
  use WithPagination, WithoutUrlPagination; 
  public $user_id;


  public function mount()
  {

    $this->user_id = Auth::id();
  }

  #[On('echo-private:NewRequest.{user_id},RequestEventMis')]
  public function request_event($e)
  {

    if (!is_null($e['notifMessage'])) {
    }

    
    $this->dispatch('update-request');
    $this->dispatch('update-task');
    $this->dispatch('update-count');
    
  }


  #[On('update-request')]
  public function render()
  {

    $task = Task::where('technicalStaff_id', Auth::id());

    $Task_RequestId = $task->pluck('request_id')->unique();

    switch(Auth::user()->role){

      case 'Faculty':
        $request = Request::where('faculty_id', $this->user_id)->with('faculty')->paginate(10);
        break;

      case 'Technical Staff':
        $request = Request::whereIn('id', $Task_RequestId)->paginate(10);
        break;

      case 'Mis Staff':
         $request = Request::with('faculty')->get();
        break;
        
    };


      return view('livewire.request.view-request', compact('request'));

    
  }
}
