<?php

namespace App\Livewire\TaskList;

use App\Models\TaskList;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteList extends Component
{
    #[On('delete-task-list')]
    public function delete($id)
    {
        $tl = TaskList::find($id);


        $tl->delete();
        $this->dispatch('success', name: 'deleted successfully');


        $this->dispatch('view-category');
    }
    public function render()
    {
        return view('livewire.task-list.delete-list');
    }
}
