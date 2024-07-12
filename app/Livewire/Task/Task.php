<?php

namespace App\Livewire\Task;

use App\Models\TechnicalStaff;
use Livewire\Component;

class Task extends Component
{
    public $tech;
    
    public function mount(){
        $this->tech = TechnicalStaff::get();
    }
    public function render()
    {
        return view('livewire.task.task');
    }
}
