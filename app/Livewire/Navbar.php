<?php

namespace App\Livewire;

use App\Models\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{

    public $route;
    public function mount(){

        $this->route = FacadesRequest::route()->getName() ?? '/';
    }

    #[On('update-count')]
    public function render()
    {
        $request = Request::count();
        $route = $this->route;
        return view('livewire.navbar', compact('request', 'route'));
    }
}
