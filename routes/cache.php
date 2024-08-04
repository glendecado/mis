<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

//clear livewire tmp
Route::get('/adasdaswerwedsf23sdf', function(){
    $oldFile = Storage::files('livewire-tmp');

    foreach($oldFile as $f){
        Storage::delete($f);
    }
    return redirect('/profile');
})->name('tmp');
