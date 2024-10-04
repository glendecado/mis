<?php

namespace App\Livewire\TaskList;

use App\Models\Category;
use App\Models\Request;
use App\Models\TaskList;
use Livewire\Component;

class ViewList extends Component
{
    public $category;
    public $request;

    public $checked;
    public $w;

    public function mount($request)
    {

        $this->request = $request;

        $this->checked = $this->request->progress / count($request->category->taskList) * 100;

        $this->w = 'style=width:'. $this->request->progress .'%;';
  
    }

    public function check($payload)
    {

        if($this->checked < $payload){

            $this->dispatch('success', name: 'step ' . $payload . ' completed ');
        }else {
            

            $this->dispatch('success', name: 'undo steps ');
        }
        $this->checked = $payload;
        $this->request->progress = round($this->checked / count($this->request->category->taskList) * 100);
        $req = Request::find($this->request->id);
        $req->progress = $this->request->progress;
        $req->save();


    }
    public function render()
    {
        return view('livewire.task-list.view-list');
    }
}
