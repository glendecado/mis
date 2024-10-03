<?php

namespace App\Livewire\TaskList;

use App\Models\Category;
use App\Models\TaskList;
use Livewire\Component;

class ViewList extends Component
{
    public $category;
    public $taskList;

    public function mount($category)
    {
        $this->category = Category::find($category->id);
    
    }

    public function render()
    {
        return view('livewire.task-list.view-list');
    }
}
