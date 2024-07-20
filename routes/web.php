<?php

use App\Livewire\Mis\MisStaff;
use App\Livewire\Request\ViewRequest;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');


Route::middleware(['Auth'])->group(function () {

    Route::get('/profile', Profile::class)->name('profile');

    Route::get('/request', ViewRequest::class)->name('request');

});

Route::middleware(['Mis'])->group(function () {

    Route::get('/manage/user', MisStaff::class)->name('manage-user');
});
