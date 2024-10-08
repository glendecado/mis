<?php

namespace App\Livewire\Mis;

use App\Models\Faculty;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class AddUser extends Component
{
    // this global variables is connect to wire:model="<name of glabal variable>"
    public $name = '';
    public $email = '';
    public $role = 'Technical Staff'; // Default role
    public $password = '';
    public $college = 'Cas'; // Default
    public $building = '';
    public $room = '';
    public $faculty = ['name', 'email', 'college', 'building', 'room', 'password'];
    public $techStaff = ['name', 'email', 'password'];


    // Validation rules for the form inputs
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'role' => 'required',
        'password' => 'required|min:6',
        //if role is faculty
        'building' => 'required_if:role,Faculty',
        'room' => 'required_if:role,Faculty',
    ];

    // Method to handle user creation
    public function AddUser()
    {

        Cache::forget('users');
        // Validate form inputs based on the rules defined
        $this->validate();

        try {

            if ($this->role == 'Mis Staff') {
                $this->dispatch('error', name: 'Can\'t add another Mis');
            } else {


                // Create a new User record
                $user = User::create([
                    'role' => $this->role,
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);


                //check role if technical Staff or Faculty
                switch ($this->role) {

                        //if technical staff /////////
                    case "Technical Staff":
                        $tech = TechnicalStaff::create([
                            'technicalStaff_id' => $user->id,
                            'totalRate' => 0,
                            'totalTask' => 0,
                        ]);
                        // Associate the User model with the TechnicalStaff model
                        $tech->User()->associate($user);
                        $tech->save();
                        break;

                        //if faculty ///////////
                    case "Faculty":
                        $fac = Faculty::create([
                            'faculty_id' => $user->id,
                            'college' => $this->college,
                            'building' => $this->building,
                            'room' => $this->room,
                        ]);
                        // Associate the User model with the Faculty model
                        $fac->User()->associate($user);
                        $fac->save();
                        break;
                }


                $this->reset(); //reset forms input
                $this->dispatch('success', name: 'User had been added successfully.'); //dispatch to js sweet alert
                $this->dispatch('user-update'); //table update
                $this->dispatch('close-modal', 'add-user-modal');
            }
        } catch (Throwable $e) {

            // Dispatch error message if an exception occurs
            $this->dispatch('error', name: 'error');
        }
    }
    // Method to reset validation errors
    #[On('reset-validation')]
    public function resetValidationErrors()
    {

        $this->resetErrorBag();
        $this->reset();
    }
}
