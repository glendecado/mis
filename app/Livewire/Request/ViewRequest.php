<?php

namespace App\Livewire\Request;

use App\Models\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;


class ViewRequest extends Component
{

  public $user_id;


  #[Url]
  public $status = '';

  public function mount()
  {

    $this->user_id = Auth::id();
    if(Auth::user()->role == 'Technical Staff'){
      $this->status = 'accepted';
    }
  }

  #[On('echo-private:NewRequest.{user_id},RequestEventMis')]
  public function request_event($e)
  {


    $this->dispatch('view-request');
    $this->dispatch('view-task');
    $this->dispatch('update-count');
    
  }

  #[On('view-request')]
  public function modal($id) {
    $this->dispatch('open-modal', 'view-request-'.$id);
  }


  #[Layout('components.layouts.request-page')]
  #[On('view-request')]
  public function render()
  {





    switch (Auth::user()->role) {

      case 'Faculty':

        $request = Request::where('faculty_id', $this->user_id)->where('status', 'like', '%' . $this->status . '%')->orderBy('created_at')->get();
        

        
 

        break;

      case 'Technical Staff':


        // Get all tasks where the technicalStaff_id matches the authenticated user's ID
        $task = Task::where('technicalStaff_id', Auth::id())->where('status', $this->status);

        // Extract the unique request IDs associated with the tasks
        $Task_RequestId = $task->pluck('request_id')->unique();

        // Retrieve all requests where the ID matches any of the request IDs from the tasks
        // Use whereIn to allow matching against an array of IDs
        $request = Request::whereIn('id', $Task_RequestId)->get();
        break;

      case 'Mis Staff':
        $request = Request::with('faculty')->where('status', 'like', '%' . $this->status . '%')->orderBy('created_at')->get();
        break;
    };


    return view('livewire.request.view-request', compact('request'));
  }

  public function updatedStatus($value)
  {
    $this->render();
  }
}
