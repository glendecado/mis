<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function (User $user, $id) {
    return $user->id === (int) $id;
});

Broadcast::channel('request-channel.{id}', function (User $user, $id) {

    return $user->id === (int) $id;
});



Broadcast::channel('online-users', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});