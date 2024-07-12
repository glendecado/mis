<?php

namespace App\Livewire\Task;

use Livewire\Attributes\On;
use Livewire\Component;

class ViewTask extends Component
{
    #[On('view-assigned')]
    public function modal($id)
    {
        $this->dispatch('open-modal', 'assigned-' . $id);
    }

}
