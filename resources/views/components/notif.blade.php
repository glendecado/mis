<?php

use App\Models\User;

use function Livewire\Volt\{computed, mount, on, state};

state(['user']);

mount(function () {

    $this->user = User::find(session('user')['id']);
});

$opened = function ($id, $req) {

    $this->user->unreadNotifications->find($id)->markAsRead();
    $this->redirect($req);
};

?>
@volt
<div x-data="{notif: false}">

    <div @click="notif = !notif" class="relative" @click.outside="notif = false">

        @if($user->unreadNotifications->count() > 0)
        <div class="bg-red-500 rounded-full w-fit h-5 p-1 text-white absolute right-0 top-0 flex justify-center items-center -translate-y-1 translate-x-1 transition-all">
            <span class="text-md font-thin p-1">{{$user->unreadNotifications->count()}}</span>
        </div>
        @endif
        <x-icons.bell class="size-9 text-white border-2 rounded-full" />
    </div>


    <div id="ntf" x-cloak x-show="notif" class="dropdown w-64 md:w-96 absolute flex  flex-col gap-2 top-16 h-96 scrollbar-hidden right-6 pt-5 p-1"
        x-init="Echo.private('App.Models.User.' + {{session('user')['id']}}).notification((notification) => {
            $wire.$refresh();
            console.log(notification);
            });">

        @switch(session('user')['role'])
        @case('Mis Staff')
        {{--Unread--}}
        @foreach ($user->unreadNotifications as $notification)
        <div class="font-bold relative flex items-center  rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4" wire:click="opened('{{$notification->id}}', '{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-14 h-14 ml-3">
            </div>
            <div class="flex w-60 flex-col overflow-hidden truncate ">
                <span class="text-wrap">{{$notification->data['name']}}</span>
                <span>{{$notification->data['message']}}</span>
                <div>Concerns:{{$notification->data['concerns']}}</div>
                <div class="text-sm hidden md:block text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
            <div class="w-4 h-4 rounded-full bg-blue absolute top-2 right-2"></div>
        </div>
        @endforeach

        {{--read--}}
        @foreach ($user->readNotifications as $notification)
        <div class="relative flex items-center rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4" @click="Livewire.navigate('{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-14 h-14 ml-3">
            </div>
            <div class="flex w-60 flex-col overflow-hidden">
                <span class="text-wrap">{{$notification->data['name']}}</span>
                <span>{{$notification->data['message']}}</span>
                <span class="truncate">Concerns: {{$notification->data['concerns']}}</span>
                <div class="text-sm text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
        </div>

        @endforeach
        @break

        @case('Faculty')
        
        {{--unread--}}
        @foreach ($user->unreadNotifications as $notification)
        <div class="relative flex items-center rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4 font-bold" wire:click="opened('{{$notification->id}}', '{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <span class="rounded-full text-[30px] ml-3">
                    🕒
                </span>
            </div>
            <div class="flex w-60 flex-col overflow-hidden">
                <span class="text-wrap">Your request, made on {{\Carbon\Carbon::parse($notification->data['date'])->format('F j, Y g:i A')}} </span>
                <span>is currently {{$notification->data['status']}}.</span>
                <div class="text-sm text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
            <div class="w-4 h-4 rounded-full bg-blue absolute top-2 right-2"></div>
        </div>
        @endforeach

        {{--read--}}
        @foreach ($user->readNotifications as $notification)
        <div class="relative flex items-center rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4" @click="Livewire.navigate('{{$notification->data['redirect']}}')">
        <div class="rounded-full p-3">
                <span class="rounded-full text-[30px] ml-3">
                    🕒
                </span>
            </div>
            <div class="flex w-60 flex-col overflow-hidden">
                <span class="text-wrap">Your request, made on {{\Carbon\Carbon::parse($notification->data['date'])->format('F j, Y g:i A')}} </span>
                <span>is currently {{$notification->data['status']}}.</span>
                <div class="text-sm text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
        </div>
        @endforeach
        @break

        @endswitch
    </div>
</div>
@endvolt