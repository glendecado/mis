<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['guest'])->group(function () {
  Volt::route('/', 'user/login')->name('login');
});


Route::middleware(['auth'])->group(function () {



  Volt::route('/dashboard', 'request')->name('dashboard');


  Volt::route('/profile/{id}', 'user/profile')->name('profile');

  Volt::route('/edit-profile/{id}', 'user/update-profile')->name('update')->middleware('edit');

  Volt::route('/admin-panel', 'admin/admin-panel')->name('admin-panel');

  Volt::route('/request', 'request')->name('request-table');


  //for Mis Staff
  Route::middleware(['role:Mis Staff'])->group(function () {

    Volt::route('/category', 'category')->name('category');
    Volt::route('/user', 'mis-staff')->name('user');

  });


  //for authorized request
  Route::middleware(['request'])->group(function () {
    Volt::route('/request/{id}', 'request')->name('request');
  });
});
