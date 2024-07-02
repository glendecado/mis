<?php

namespace App\Livewire\Request;

use App\Events\RequestEventMis;
use App\Models\Request as ModelsRequest;
use Database\Seeders\Faculty;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\MountManager;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class Request extends Component
{
    public $faculty_id;
    public $category;
    public $concerns;
    public $status = 'waiting';
    public $selecStatus;



    protected $rules = [
        'category' => 'required|string|max:255',
        'concerns' => 'required|string',
        'status' => 'required|string|max:255',
    ];


    public function mount()
    {

        $this->faculty_id = Auth::user()->id;
    }


    public function addRequest()
    {
        $this->validate();

        $req = ModelsRequest::create(
            [
                'faculty_id' => Auth::user()->id,
                'category' => $this->category,
                'concerns' =>  $this->concerns,
                'status' => $this->status,
            ]
        );

        $req->save();


        RequestEventMis::dispatch(1);

        $this->reset('category');
        $this->reset('concerns');
        $this->dispatch('success', name: 'Request successfully sent.');
    }


    #[On('request-delete')]
    public function deleteRequest($id){
        try{
            $req = ModelsRequest::find($id);
            $req->delete();
            $this->dispatch('success', name: 'Request Deleted Successfully');
        }
        catch(Throwable $e)
        {
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
            return view('livewire.request.request', ['request' => ModelsRequest::where('faculty_id', $this->faculty_id)->get()]);
        }
        if (Auth::user()->role == 'Mis Staff') {
            return view('livewire.request.request', ['request' => ModelsRequest::get()]);
        }
    }
}
