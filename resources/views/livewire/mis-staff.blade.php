<?php

use App\Models\Faculty;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use function Livewire\Volt\{state, mount, on, rules, title};

title('Users');

state(['cacheKey']);

state('roles')->url();

state(['role', 'fname', 'lname', 'email', 'password', 'status'=>'active']);

state(['college', 'building', 'room']);

rules([
    'role' => 'required|string',
    'fname' => 'required|string|max:100',
    'lname' => 'required|string|max:100',
    'email' => 'required|email|unique:users,email', // Adjust table name if necessary
    'password' => 'required|min:6',
    'college' => 'nullable|string|max:100',
    'building' => 'nullable|string|max:100',
    'room' => 'nullable|string|max:50',
])->messages([
    'fname.required' => "The first name field is required.",
    'lname.required' => "The last name field is required."

]);

on(['resetErrors' => function () {
    $this->resetErrorBag();
    $this->role = 'Technical Staff';
    $this->reset('fname');
    $this->reset('lname');
    $this->reset('email');
    $this->reset('password');
    $this->reset('college');
    $this->reset('building');
    $this->reset('room');
}]);


//view user
$viewUser = function () {
    switch ($this->roles) {
        case 'all':
            $user = User::where('role', '!=', 'Mis Staff')->get();

            break;

        case 'faculty':
            $user = User::where('role', 'Faculty')->get();

            break;

        case 'technicalStaff':
            $user =  User::where('role', 'Technical Staff')->get();

            break;

        default:
            # code...
            break;
    }

    return $user;
};

//create user
$addUser = function () {
    $this->validate();
    // Create a new User record
    $user = User::create([
        'role' => $this->role,
        'name' => $this->fname . ' ' . $this->lname,
        'email' => $this->email,
        'password' => $this->password,
    ]);

    //check role if technical Staff or Faculty
    switch ($this->role) {
        //if technical staff /////////
        case 'Technical Staff':
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
        case 'Faculty':
            $fac = Faculty::create([
                'faculty_id' => $user->id,
                'college' => $this->college ?? 'CAS',
                'building' => $this->building,
                'room' => $this->room,
            ]);
            // Associate the User model with the Faculty model
            $fac->User()->associate($user);
            $fac->save();
            break;
    }
    //to reset the form 
    $this->reset([
        'role',
        'fname',
        'lname',
        'email',
        'password',
        'college',
        'building',
        'room'
    ]);
    $this->dispatch('close-modal', 'add-user-modal');


    $this->dispatch('success', 'Added Successfully');
};

$userUpdateUser = function ($id) {
    $user = User::find($id); // No need for ->first(), find() already returns a single model or null

    if ($user) { // Check if user exists to prevent errors
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
    }
};


$viewDetailedUser = function () {};

?>

<div class="bg-blue-50 rounded-md shadow-md shadow-blue-950/20">

    @include('components.mis.users')
    @include('components.mis.add-user-button')


</div>