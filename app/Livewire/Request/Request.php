<?php

namespace App\Livewire\Request;

use App\Models\Request as ModelsRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Request extends Component
{
    public $faculty_id;
    public $category;
    public $concerns;
    public $status;

    public $requests;

    protected $rules = [
        'category' => 'required|string|max:255',
        'concerns' => 'required|string',
        'status' => 'required|string|max:255',
    ];

    public function mount(){
        $this->requests = ModelsRequest::where('faculty_id', Auth::user()->faculty->id)->get();
    }
    public function addRequest()
    {
        $this->validate();

        $req = ModelsRequest::create([
            'faculty_id' => Auth::user()->Faculty->id,
            'category' => $this->category,
            'concerns' => $this->concerns,
            'status' => $this->status,
        ]);

        $req->Faculty()->associate(Auth::user()->Faculty);
        $req->save();

        // Optionally reset the form fields after submission
        $this->reset();
    }

    public function render()
    {
        return view('livewire.request.request');
    }
}
