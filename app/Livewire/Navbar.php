<?php

namespace App\Livewire;

use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{

    public $route;
    public $search;
    public function mount()
    {

        $this->route = FacadesRequest::route()->getName() ?? '/';
    }

    #[On('update-count')]
    public function render()
    {
        $user = DB::table('users')
            ->where('role', '!=', 'Mis Staff')
            ->where(function ($query) {
                $query->where('name', 'like', "%$this->search%")
                    ->orWhere('id', 'like', "%$this->search%")
                    ->orWhere('email', 'like', "%$this->search%");
            })->get();
        $request = Request::count();
        $route = $this->route;
        return view('livewire.navbar', compact('request', 'route', 'user'));
    }
}
