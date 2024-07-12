<?php

namespace App\Livewire\Request;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewRequest extends Component
{
  public $request;

    #[On('view-request')]
    public function viewRequest($id)
  {
      $this->dispatch('open-modal',  'view-request-' . $id );
      $this->request = Request::findOrFail($id);

      
    }


  #[On('update-request')]
  public function render()
  {
    $faculty_id = Auth::user()->id;

    if (Auth::user()->role == 'Faculty') {
      return view('livewire.request.view-request', ['reqs' => Request::where('faculty_id', $faculty_id)->get()]);
    }
    if (Auth::user()->role == 'Mis Staff') {
      return view('livewire.request.view-request', ['reqs' => Request::get()]);
    }
  }
}
