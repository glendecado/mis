<?php

namespace App\Livewire\Task;


use App\Models\Task;
use App\Models\TechnicalStaff;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateTask extends Component
{
    public $tech;

    public function mount(){
       $this->tech = TechnicalStaff::find(Auth::id());
    }

    #[On('accept-task')]
    public function acceptTask($id)
    {
        $task = Task::where('request_id', $id)->where('technicalStaff_id', Auth::id())->first();
        $task->status = 'accepted';
        $task->save();
        $this->dispatch('ongoing-request', id: $id);
        $this->dispatch('close-modal', 'view-request-' . $id);
        $this->dispatch('success', name: 'Task accepted Sucessfully');
        $this->dispatch('view-request');

        $this->tech->totalPendingTask -= 1;
        $this->tech->totalOngoingTask += 1;
        $this->tech->save();
    }

    #[On('reject-task')]
    public function rejectTask($id)
    {

        $task = Task::where('request_id', $id)->where('technicalStaff_id', Auth::id())->first();
        $task->status = 'rejected';
        $task->save();
        $this->dispatch('close-modal', 'view-request-' . $id);
        $this->dispatch('error', name: 'Task rejected');
        $this->dispatch('view-request');

        $this->tech->totalPendingTask -= 1;
        $this->tech->totalRejectedTask += 1;
        $this->tech->save();
    }

    public function render()
    {
        return view('livewire.task.update-task');
    }
}
