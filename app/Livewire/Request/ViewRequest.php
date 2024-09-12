<?php

namespace App\Livewire\Request;

use App\Models\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;


class ViewRequest extends Component
{

  public $user_id;

  #[Url(keep: true)]
  public $status = '';

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

  #[On('view-request')]
  public function modal($id) {
    $this->dispatch('open-modal', 'view-request-'.$id);
  }


  #[On('update-request')]
  public function render()
  {





    switch (Auth::user()->role) {

      case 'Faculty':
        $request = Request::where('faculty_id', $this->user_id)->with('faculty')->get();
        break;

      case 'Technical Staff':

        $request = Request::with('faculty')
          ->join('tasks', 'requests.id', '=', 'tasks.request_id')
          ->where('tasks.technicalStaff_id', Auth::id())
          ->where('tasks.status', $this->status)
          ->orderBy('requests.priorityLevel')
          ->get();
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
