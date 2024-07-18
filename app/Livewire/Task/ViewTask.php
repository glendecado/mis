<?php

namespace App\Livewire\Task;

use App\Models\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewTask extends Component
{
    #[On('view-assigned')]
    public function modal($id)
    {
        $this->dispatch('open-modal', 'assigned-' . $id);
    }

    public function render()
    {
        return view('livewire.task.view-task',
            [
            'request' => Request::get(),
            'technicalStaff' => \App\Models\TechnicalStaff::with('user')->get()
            ]
        );
    }
}
