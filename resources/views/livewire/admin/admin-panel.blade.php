<?php

use App\Models\Request;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{layout, mount, state, title};
title('Admin panel');

state('tab')->url();

layout('components.layouts.admin');
?>

<div class="basis-full">

    {{-- Sidebar Section --}}
    @include('livewire.admin.sidebar-admin')

    {{-- content Section --}}
    @section('content')
        @switch($tab)
            {{-- content Section --}}
            @case('requests')
                <livewire:request />
            @break

            @case('users')
                <livewire:mis-staff />
            @break

            @case('categories')
                <livewire:category />
            @break
        @endswitch
    @endsection


</div>
