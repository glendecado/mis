<?php

namespace App\Livewire\Request;

use App\Events\RequestEventMis;
use App\Models\Request as ModelsRequest;
use Database\Seeders\Faculty;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\MountManager;
use Livewire\Attributes\On;
use Livewire\Component;

class Request extends Component
{
    public $faculty_id;
    public $category;
    public $concerns;
    public $status = 'waiting';
    public $selecStatus;

    public $request;
    public $requestList = [];


    protected $rules = [
        'category' => 'required|string|max:255',
        'concerns' => 'required|string',
        'status' => 'required|string|max:255',
    ];


    public function mount()
    {


        $this->faculty_id = Auth::user()->id;

        if(Auth::user()->role == 'Faculty'){
            $request = ModelsRequest::where('faculty_id', $this->faculty_id)->get();//only user and user with the role of Mis Staff can
        }

        elseif(Auth::user()->role == 'Mis Staff'){
            $request = ModelsRequest::get();
        }

        foreach($request as $re){
            $this->requestList[] = [
                'id' => $re['id'],
                'faculty_id' => $re['faculty_id'],
                'category' => $re['category'],
                'concerns' => $re['concerns'],
                'status' => $re['status'],
            ];
        }

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


        RequestEventMis::dispatch(
            $req['id'], 
            $req['faculty_id'], 
            $req['category'], 
            $req['concerns'], 
            $req['status'], 
            1); 

        $this->reset('category');
        $this->reset('concerns');
        $this->reload();
        $this->dispatch('alert', name: 'Request successfully sent.');
    }

    #[On('echo-private:NewRequest.{faculty_id},RequestEventMis')]
    public function listenAddRequest($e)
    {
        $this->requestList[] = $e;
    }


    #[On('update-request')]
    public function render()
    {

        return view('livewire.request.request');
    }
}
