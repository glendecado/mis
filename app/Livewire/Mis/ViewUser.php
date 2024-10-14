<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ViewUser extends Component
{
    #[Url(history: true)]
    public $search;




    #[On('user-update')]
    public function render()
    {

        $users = DB::table('users')
            // Filter out users who have the role 'Mis Staff'
            ->where('role', '!=', 'Mis Staff')
            // Apply additional search criteria using a nested function
            //
            ->where(function ($query) {
                // Search for users where the 'name', 'id', or 'email' matches the search term
                $query->where('name', 'like', "%$this->search%")
                    ->orWhere('id', 'like', "%$this->search%")
                    ->orWhere('email', 'like', "%$this->search%");
            })->get();

        //fetch users


        //** Nested where Clauses: The nested where clause (with the closure) is used here to group the orWhere conditions. This ensures that the search terms apply to either --name, id, or email--, while the --role-- condition remains separate.*/
        return view('livewire.mis.view-user', ['users' => $users]);
    }
}
