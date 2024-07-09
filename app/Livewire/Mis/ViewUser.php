<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewUser extends Component
{

    public $search;

    #[On('data-update')]
    public function render()
    {

        return view('livewire.mis.view-user', ['users' => User::where('role', '!=', 'Mis Staff')->where('name', 'like', "%$this->search%")->paginate(10)]);
    }
}
