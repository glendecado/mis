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
    public $users;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'role' => 'required',
        'password' => 'required|min:6',
        'building' => 'required_if:role,Faculty',
        'room' => 'required_if:role,Faculty',
    ];

    public function mount()
    {
        $this->users = User::where('role', '!=', 'Mis Staff')->get();
    }

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
            $Techstaff = TechnicalStaff::create([
                'user_id' => $user->id,
                'totalRate' => 0,
                'totalTask' => 0,
            ]);
        } elseif ($this->role == "Faculty") {
            $Faculty = Faculty::create([
                'user_id' => $user->id,
                'college' => $this->college,
                'building' => $this->building,
                'room' => $this->room,
            ]);
        }

        $this->reset();

        return redirect('/manage/user');
    }

    public function DeleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/manage/user');
    }

    #[On('resetValidation')] 
    public function resetValidationErrors()
    {
        $this->resetErrorBag();
    }
    public function render()
    {
        return view('livewire.mis.mis-staff');
    }
}
