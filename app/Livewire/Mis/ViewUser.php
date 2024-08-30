<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ViewUser extends Component
{
    #[Url(history: true)]
    public $search;

    #[On('modal-update')]
    public function modal($id){
        $this->dispatch('open-update-modal', id : $id);
    }


    #[On('user-update')]
    public function render()
    {

        $users = DB::table('users')
            ->where('role', '!=', 'Mis Staff')
            ->where(function ($query) {
                $query->where('name', 'like', "%$this->search%")
                    ->orWhere('id', 'like', "%$this->search%")
                    ->orWhere('email', 'like', "%$this->search%");
            })->get()
            ;

        return view('livewire.mis.view-user', ['users' => $users]);
    }
}
