<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
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

       $this->categories = Cache::remember('categories', now()->addHours(1), function () {
            return Category::with('TaskList')->get();
        });

        $this->dispatch('category-added');
    }
    #[On('category-added')]
    public function updateCache()
    {
        // Clear and refresh the cache when a new category is added
        Cache::forget('categories');
        $this->categories = Category::with('TaskList')->get();
        Cache::put('categories', $this->categories, now()->addHours(1));
    }

    public function render()
    {

        return view('livewire.category.view-category');
    }
}
