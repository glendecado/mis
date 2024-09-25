<?php

namespace App\Livewire\TaskList;

use App\Models\TaskList;
use Livewire\Attributes\On;
use Livewire\Component;

class AddList extends Component
{

 
    #[On('add-task-list')]
    public function add($tasks, $id)
    {
        
        if($tasks == null){
            
            $this->dispatch('error', name: 'Empty');

        }else{
 
        TaskList::create(['category_id'=>$id, 'task' =>$tasks]);
        $this->dispatch('view-category');
        $this->dispatch('success', name: 'Task added successfully');
        $this->dispatch('input-category-reset');
        }
    }
    public function render()
    {
        return view('livewire.task-list.add-list');
    }
}
