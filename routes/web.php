<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['guest'])->group(function () {
  Volt::route('/', 'user/login')->name('login');
});


Route::middleware(['auth'])->group(function () {



  Volt::route('/dashboard', 'user/dashboard')->name('dashboard');


  Volt::route('/profile/{id}', 'user/profile')->name('profile');

  Volt::route('/admin-panel', 'admin/admin-panel')->name('admin-panel');
  
  Volt::route('/request', 'request')->name('requests');

  Route::middleware(['request'])->group(function () {

    Volt::route('/request/{id}', 'request')->name('request');
  });

});
