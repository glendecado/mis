<?php

use App\Livewire\Mis\MisStaff;
use App\Livewire\Mis\ViewUser;
use App\Livewire\Request\ViewRequest;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');


Route::middleware(['Auth'])->group(function () {

    Route::get('/profile', Profile::class)->name('profile');

    Route::get('/request', ViewRequest::class)->name('request');



});

Route::middleware(['Mis'])->group(function () {

    Route::get('/manage/user', ViewUser::class)->name('manage-user');
});



// routes/web.php

Route::delete('/deletenotif/{id}', function ($id) {
    $notifications = Cache::get('notif-' . Auth::id());

    // Check if notifications exist and remove the specified one
    if (isset($notifications[$id])) {
        unset($notifications[$id]);
        Cache::put('notif-' . Auth::id(), array_values($notifications)); // Reindex array
    }

    return redirect('/');
});
