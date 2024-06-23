<?php


use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('/profile', Profile::class)->name('profile');