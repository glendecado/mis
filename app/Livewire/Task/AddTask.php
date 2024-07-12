<?php

namespace App\Livewire\Task;

use Livewire\Attributes\On;
use Livewire\Component;

class AddTask extends Component
{
    #[On('add-tech')]
    public function addTask($selectedValues)
    {
        dd($selectedValues);
    }



    public function render()
    {
        return view('livewire.task.add-task');
    }
}
