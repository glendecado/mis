<?php

namespace App\Livewire\Mis;

use App\Models\Faculty;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MisStaff extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search;

    #[On('reset-validation')]
    public function resetValidationErrors()
    {
        $this->resetErrorBag();
        $this->reset();
    }


    #[On('data-update')]
    public function render()
    {

        return view('livewire.mis.mis-staff', ['users' => User::where('role', '!=', 'Mis Staff')->where('name', 'like', "%$this->search%")->paginate(10)]);
    }
}
