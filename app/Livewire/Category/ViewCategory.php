<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;


#[Layout('components.layouts.request-page')]
class ViewCategory extends Component
{
    public $categories;
    public $open = false;
    public $openThis;

    public $tasks;
    protected $rules = [
        'tasks' => 'required|min:3|max:255', // Adjust rules as needed
    ];
    
    public function submitInput($payload){

        $this->openThis = $payload[0];
        $this->open = $payload[1];
    }


    #[On('input-category-reset')]
    public function resetInputs(){
        $this->tasks = '';
    }

    #[On('view-category')]
    public function mount(){
        $this->categories = Category::with('TaskList')->get();
    }
    public function render()
    {

        return view('livewire.category.view-category');
    }
}
