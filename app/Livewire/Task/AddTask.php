<?php

namespace App\Livewire\Task;

use Livewire\Attributes\On;
use Livewire\Component;

class AddTask extends Component
{
    #[On('add-task')]
    public function addTask($request_id, $tech_id)
    {
        $r = [$request_id, $tech_id];
        
        dd($r);
    }



    public function render()
    {
        return view('livewire.task.add-task');
    }
}
