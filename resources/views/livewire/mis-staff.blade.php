<?php

use App\Models\Faculty;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{state, mount, on, rules};

state(['cacheKey']);

state('user')->url();

state(['role', 'fname', 'lname', 'email', 'password']);

state(['college', 'building', 'room']);

rules([
    'role' => 'required|string|max:50',
    'fname' => 'required|string|max:100',
    'lname' => 'required|string|max:100',
    'email' => 'required|email|unique:users,email', // Adjust table name if necessary
    'password' => 'required|min:6',
    'college' => 'nullable|string|max:100',
    'building' => 'nullable|string|max:100',
    'room' => 'nullable|string|max:50',
]);

on(['resetErrors' => function () {
    $this->resetErrorBag();
}]);

mount(function () {
    $this->cacheKey = "users_";
});

//forget cache
$forgetCache = function () {
    $roles = ['all', 'faculty', 'technicalStaff'];
    foreach ($roles as $role) {
        Cache::forget("users_{$role}");
    }
};

//view user
$viewUser = function () {
    switch ($this->user) {
        case 'all':
            $user = Cache::rememberForever($this->cacheKey.'all', function () {
                return User::where('role', '!=', 'Mis Staff')->get();
            });
            break;

        case 'faculty':
            $user = Cache::rememberForever($this->cacheKey.'faculty', function () {
                return User::where('role', 'Faculty')->get();
            });
            break;

        case 'technicalStaff':
            $user = Cache::rememberForever($this->cacheKey.'technicalStaff', function () {
                return User::where('role', 'Technical Staff')->get();
            });
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
                'college' => $this->college,
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
    $this->forgetCache();

    $this->dispatch('success', 'Added Successfully');
};

$deleteUser = function ($id) {
    $user = User::find($id);
    $user->delete();
    $this->forgetCache();

   $this->dispatch('success', 'Deleted Successfully');
}

?>

<div class="h-[80vh] overflow-auto basis-full p-2 bg-blue-50">
    @include('components.mis.add-user-button')
    @include('components.mis.users')
    <x-alerts />

</div>