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
    public $request;
    #[On('view-assigned')]
    public function modal($id)
    {
        $this->dispatch('open-modal', 'assigned-' . $id);
        $this->id = $id;
    }


    #[On('update-task')]
    public function render()
    {
        $task = Task::where('request_id', $this->id)->get();

        $assigned = $task->pluck('technicalStaff_id')->toArray();


        return view(
            'livewire.task.view-task',
            [
                'task' => $assigned,
                'request' => $this->request,
                'technicalStaff' => TechnicalStaff::with('user')->get()
            ]
        );
    }
}
