<?php

use App\Livewire\Mis\MisStaff;
use App\Livewire\Request\Request;
use App\Livewire\Task\Task;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('/profile', Profile::class)->name('profile');

Route::get('/request', Request::class)->name('request');


Route::get('/manage/user', MisStaff::class)->name('manage-user');

Route::get('/task', Task::class)->name('task');