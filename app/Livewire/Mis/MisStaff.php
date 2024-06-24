<?php

namespace App\Livewire\Mis;

use App\Models\Faculty;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;


class MisStaff extends Component
{
    public $name = '';
    public $email = '';
    public $role = 'Technical Staff';
    public $password = '';
    public $college = 'Cas';
    public $building = '';
    public $room = '';



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


        if ($this->role == 'Faculty') {
            $this->dispatch('add-faculty');
        } elseif ($this->role == 'Technical Staff') {
            $this->dispatch('add-techstaff', 
            name:$this->name, role:$this->role, email:$this->email, password:$this->password, totalRate:0, totalTask:0);
        }

        $this->reset();
        session()->flash('success', 'User had been added successfully.');

       
    }

    
    public function DeleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/manage/user');
    }


    public function resetValidationErrors()
    {
       $this->dispatch('resetValidation', Name: $this->users);
    }

 
    #[On('data-update')]
    public function render()
    {

        return view('livewire.mis.mis-staff', ['users' => User::where('role', '!=', 'Mis Staff')->get()]);
    }
}
