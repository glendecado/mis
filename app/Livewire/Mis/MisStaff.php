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
    public $name = '';
    public $email = '';
    public $role = 'Technical Staff';
    public $password = '';
    public $college = 'Cas';
    public $building = '';
    public $room = '';

    #[Url(history: true)]
    public $search;


    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'role' => 'required',
        'password' => 'required|min:6',
        'building' => 'required_if:role,Faculty',
        'room' => 'required_if:role,Faculty',
    ];


    public function AddUser()
    {
        $this->validate();

        $user = User::create([
            'role' => $this->role,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        if ($this->role == "Technical Staff") {
            TechnicalStaff::create([
                'user_id' => $user->id,
                'totalRate' => 0,
                'totalTask' => 0,
            ]);
        } elseif ($this->role == "Faculty") {
            Faculty::create([
                'user_id' => $user->id,
                'college' => $this->college,
                'building' => $this->building,
                'room' => $this->room,
            ]);
        }

        $this->reset();
        session()->flash('success', 'User had been added successfully.');
    }

    #[On('user-delete')]
    public function DeleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

    }

    #[On('reset-validation')]
    public function resetValidationErrors()
    {
        $this->dispatch('resetValidation', Name: $this->users);
    }


    #[On('data-update')]
    public function render()
    {

        return view('livewire.mis.mis-staff', ['users' => User::where('role', '!=', 'Mis Staff')->where('name', 'like', "%$this->search%")->paginate(10)]);
    }
}
