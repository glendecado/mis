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
            $tech = TechnicalStaff::create([
                'technicalStaff_id' => $user->id,
                'totalRate' => 0,
                'totalTask' => 0,
            ]);
            $tech->User()->associate($user);
            $tech->save();

        } elseif ($this->role == "Faculty") {
            $fac = Faculty::create([
                'faculties_id' => $user->id,
                'college' => $this->college,
                'building' => $this->building,
                'room' => $this->room,
            ]);

            $fac->User()->associate($user);
            $fac->save();
        }

        $this->reset();
        $this->dispatch('alert', name: 'User had been added successfully.');
    }







    

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
