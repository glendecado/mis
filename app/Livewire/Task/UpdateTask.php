<?php

namespace App\Livewire\Task;

use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateTask extends Component
{

    #[On('accept-task')]
    public function acceptTask($id){
        $task = Task::where('request_id', $id)->first();
        $task->status = 'accepted';
        $task->save();

        $this->dispatch('ongoing-request', id: $id);
    }
    
    public function render()
    {
        return view('livewire.task.update-task');
    }
}
