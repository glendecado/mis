<?php

namespace App\Livewire\Mis;

use App\Models\Faculty;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

class AddUser extends Component
{
  #[On('resetValidation')]
  public function adduser($name, $role, $email, $password)
  {

    return  User::create([
      'role' => $role,
      'name' => $name,
      'email' => $email,
      'password' => Hash::make($password),
    ]);
  }


  #[On('add-techstaff')]
  public function addTechStaff($name, $role, $email, $password, $totalRate, $totalTask)
  {


    $user = $this->adduser($name, $role, $email, $password);
    $Techstaff = TechnicalStaff::create([
      'user_id' => $user->id,
      'totalRate' => $totalRate,
      'totalTask' => $totalTask,
    ]);
    $Techstaff->User()->associate($user);
    $Techstaff->save();
    $this->dispatch('data-update');


  }

  public function render()
  {
    return view('livewire.mis.add-user');
  }
}
