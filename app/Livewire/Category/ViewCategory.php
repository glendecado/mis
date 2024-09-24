<?php

namespace App\Livewire\Category;

use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.request-page')]
class ViewCategory extends Component
{
    public function render()
    {
        return view('livewire.category.view-category');
    }
}
