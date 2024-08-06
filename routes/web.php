<?php

use App\Livewire\Mis\MisStaff;
use App\Livewire\Mis\ViewUser;
use App\Livewire\Request\ViewRequest;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    if(Auth::check()){
        return view('dashboard');
    }else{
        return view('index');
    }
});


Route::middleware(['Auth'])->group(function () {

    Route::get('/profile/{user}/', Profile::class)->name('profile');

    Route::get('/request', ViewRequest::class)->name('request');



});

Route::middleware(['Mis'])->group(function () {

    Route::get('/manage/user', ViewUser::class)->name('manage-user');
});



