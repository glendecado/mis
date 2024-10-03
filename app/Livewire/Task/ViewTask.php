<?php

namespace App\Livewire\Task;

use App\Models\Request;
use App\Models\Task;
use App\Models\TechnicalStaff;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewTask extends Component
{
    public $id;

    #[On('view-assigned')]
    public function modal($id)
    {
        $this->dispatch('open-modal', 'assigned');
        $this->id = $id;
    }


    #[On('view-task')]
    public function render()
    {
        $from_task = Task::where('request_id', $this->id)->get();

        $task = $from_task->pluck('technicalStaff_id')->toArray();

        $technicalStaff = TechnicalStaff::with('user')->get();

        return view(
            'livewire.task.view-task',compact('task', 'technicalStaff')
            
        );
    }
}
