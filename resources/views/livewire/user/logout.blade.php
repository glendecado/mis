<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\{state};

//

$logout = function () {
    cache(['online-'.session('user')['id'] => '0']);
    Auth::logout();
    Session::flush();
    return redirect()->route('login');
}

?>
<div class="dropdown-open-items p-4" wire:click.prevent="logout" @click="sessionStorage.clear()">
    <x-icons.logout class="size-6 absolute left-5" />
    <span>Logout</span>
</div>