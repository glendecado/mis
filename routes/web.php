<?php

use App\Livewire\Mis\MisStaff;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('/profile', Profile::class)->name('profile');
Route::get('/manage/user', MisStaff::class)->name('manage-user');