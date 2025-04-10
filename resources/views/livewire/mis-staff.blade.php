<?php

use App\Mail\CreatedAccount;
use App\Models\Faculty;
use App\Models\MisStaff;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

use function Livewire\Volt\{state, mount, on, rules, title};

title('Users');

state(['cacheKey']);
state('roles')->url();
state(['role', 'fname', 'lname', 'email', 'password', 'status' => 'active']);
state(['site', 'officeOrBuilding']);
state('step', 1);

rules([
    'role' => 'required|string|in:Faculty,Technical Staff,Mis Staff',
    'fname' => 'required|string|max:100',
    'lname' => 'required|string|max:100',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6|max:50',
    'site' => 'required_if:role,Faculty|string|max:100|nullable',
    'officeOrBuilding' => 'required_if:role,Faculty|string|max:100|nullable',
])->messages([
    'fname.required' => "The first name field is required.",
    'lname.required' => "The last name field is required.",
    'role.in' => "Please select a valid role.",
    'email.unique' => "This email is already registered.",
]);

mount(function () {
    session(['page' => 'user?roles=all']);
});

on(['resetErrors' => function () {
    $this->resetErrorBag();
    $this->step = 1;
    $this->reset(['role', 'fname', 'lname', 'email', 'password', 'site', 'officeOrBuilding']);
}]);

$viewUser = function () {
    return match ($this->roles) {
        'faculty' => User::where('role', 'Faculty')->get(),
        'technicalStaff' => User::where('role', 'Technical Staff')->get(),
        'misStaff' => User::where('role', 'Mis Staff')->get(),
        default => User::where('role', '!=', 'Mis Staff')->get(),
    };
};

$addUser = function () {
    $validated = $this->validate();
    
    $user = User::create([
        'role' => $this->role,
        'name' => trim($this->fname . ' ' . $this->lname),
        'email' => $this->email,
        'password' => $this->password,
        'status' => 'active',
    ]);

    match ($this->role) {
        'Technical Staff' => TechnicalStaff::create(['technicalStaff_id' => $user->id]),
        'Faculty' => Faculty::create([
            'faculty_id' => $user->id,
            'site' => $this->site,
            'officeOrBuilding' => $this->officeOrBuilding,
        ]),
        'Mis Staff' => MisStaff::create(['misStaff_id' => $user->id]),
        default => null,
    };

    $this->reset([
        'role', 'fname', 'lname', 'email', 'password', 
        'site', 'officeOrBuilding'
    ]);
    
    $this->dispatch('close-modal', 'add-user-modal');
    $this->dispatch('success', 'User added successfully');
    
    try {
        Mail::to($user->email)->send(new CreatedAccount($user));
    } catch (\Exception $e) {
        // Log email error if needed
    }
};

$userUpdateUser = function ($id) {
    $user = User::find($id);
    if ($user) {
        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
    }
};

$viewDetailedUser = function ($id) {
    // Implementation for viewing detailed user info
};

?>

<div>
    <div wire:loading wire:target="addUser" class="w-full h-dvh">
        <div class="fixed inset-0 w-full h-svh bg-black/50 z-[100] flex items-center justify-center">
            <x-loaders.b-square />
        </div>
    </div>

    @include('components.mis.users')
    @include('components.mis.add-user-button')
</div>