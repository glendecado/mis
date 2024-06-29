<?php

namespace App\Livewire\Request;

use App\Models\Request as ModelsRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Request extends Component
{
    public $faculty_id;
    public $category;
    public $concerns;
    public $status = 'waiting';


    protected $rules = [
        'category' => 'required|string|max:255',
        'concerns' => 'required|string',
        'status' => 'required|string|max:255',
    ];

  
    public function addRequest()
    {
        $this->validate();

        $req = ModelsRequest::create([
            'faculty_id' => Auth::user()->id,
            'category' => $this->category,
            'concerns' => $this->concerns,
            'status' => $this->status,
        ]);

   
       
        $this->reset();
    }

    #[On('table-req-update')]
    public function render()
    {   

        if(Auth::user()->role == 'Faculty'){
            $requests = ModelsRequest::where('faculty_id', Auth::user()->id)->paginate(6);
            $newRequest = ModelsRequest::where('faculty_id', Auth::user()->id)->where('status', 'waiting')->paginate(6);
        }
  

        return view('livewire.request.request', ['requests' => $requests, 'newRequest' => $newRequest]);
    }
}
