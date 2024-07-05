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


    public $request = [];
    protected $rules = [
        'category' => 'required|string|max:255',
        'concerns' => 'required|string',
        'status' => 'required|string|max:255',
    ];


    public function mount()
    {

        $this->faculty_id = Auth::user()->id;
 
    
    }





    #[On('view-request')]
    public function viewRequest($id)
    {
        $this->request = ModelsRequest::findOrFail($id);
        if($id != null){
            $this->dispatch('open-modal',  'view-request-' . $id . '');
           
        }else{
            $this->dispatch('error', name: 'Something went wrong');
        }

    }



    #[On('echo-private:NewRequest.{faculty_id},RequestEventMis')]
    public function req($e)
    {
      $this->dispatch('success', name: 'New Request');  
    }





    #[On('update-request')]
    public function render()
    {

        if (Auth::user()->role == 'Faculty') {
            return view('livewire.request.request', ['reqs' => ModelsRequest::where('faculty_id', $this->faculty_id)->get()]);
        }
        if (Auth::user()->role == 'Mis Staff') {
            return view('livewire.request.request', ['reqs' => ModelsRequest::get()]);
        }
    }
}
