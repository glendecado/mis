<?php

use App\Models\User;

use function Livewire\Volt\{computed, mount, on, state};

state(['user']);

mount(function () {

    $this->user = User::find(session('user')['id']);
});

$opened = function ($id, $req) {

    $notification = $this->user->unreadNotifications->firstWhere('id', $id);

    // Check if the notification exists
    if ($notification) {
        $notification->markAsRead();
    } else {
        // Handle error if needed
        // Log::error("Notification with ID {$id} not found.");
    }

    $this->redirect($req);
};

?>
@volt
<div x-data="{notif: false}">

    <div @click="notif = !notif" class="relative" @click.outside="notif = false">

        @if($user->unreadNotifications->count() > 0)
        <!-- check notif responsiveness -->
        <div class="bg-red-500 rounded-full p-1 text-white absolute right-[2px] top-[2px] flex justify-center items-center 
                    -translate-y-1 translate-x-1 transition-all 
                    w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10">
            <span class="text-md font-thin p-1">{{$user->unreadNotifications->count()}}</span>
        </div>
        @endif
        <x-icons.bell class="size-9 text-white border-2 rounded-full" />
    </div>


    <div id="ntf" x-cloak x-show="notif" class="dropdown w-72 md:w-96 absolute flex  flex-col gap-2 top-16 h-96 scrollbar-hidden right-2 pt-5 p-1"
        x-init="Echo.private('App.Models.User.' + {{session('user')['id']}}).notification((notification) => {
            $wire.$refresh();
            console.log(notification);
            });">




        {{--Unread--}}
        @foreach ($user->unreadNotifications as $notification)

        @switch($notification->type)

        @case('App\Notifications\NewRequest')
        <div class="font-bold relative flex items-center  rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4" wire:click="opened('{{$notification->id}}', '{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-14 h-14 ml-3">
            </div>
            <div class="flex w-60 flex-col overflow-hidden truncate ">
                <span class="text-wrap">{{$notification->data['name']}}</span>
                <span>Sent a Request</span>
                <div>Concerns:{{$notification->data['concerns']}}</div>
                <div class="text-sm hidden md:block text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
            <div class="w-4 h-4 rounded-full bg-blue absolute top-2 right-2"></div>
        </div>


        @break

        @case('App\Notifications\RequestStatus')
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
        @break

        @case('App\Notifications\FeedbackRating')
        <div class="font-bold relative flex items-center  rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4" wire:click="opened('{{$notification->id}}', '{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-14 h-14 ml-3">
            </div>
            <div class="flex w-60 flex-col overflow-hidden truncate ">
                <span class="text-wrap">{{$notification->data['name']}} sent rate and feedback</span>
                <div>rate: {{$notification->data['rate']}}</div>
                <div>Feedback:{{$notification->data['feedback']}}</div>
                <div class="text-sm hidden md:block text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
            <div class="w-4 h-4 rounded-full bg-blue absolute top-2 right-2"></div>
        </div>
        @break


        @case('App\Notifications\AssingedRequest')
        <div class="font-bold relative flex items-center  rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full  " wire:click="opened('{{$notification->id}}', '{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-[64px] md:h-[64px] h-[32px]">
            </div> 
            <div class="flex w-60 flex-col overflow-hidden truncate ">
                <span>You have been assigned</span>
                <span> to handle</span>
                <span class="text-wrap">{{$notification->data['name']}} 's</span>
                <span>request.</span>
                <div>Category:{{$notification->data['category']}}</div>
                <div class="text-sm hidden md:block text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
            <div class="w-4 h-4 rounded-full bg-blue absolute top-2 right-2"></div>
        </div>
        @break

        @endswitch

        @endforeach









        {{--read--}}
        @foreach ($user->readNotifications as $notification)

        @switch($notification->type)

        @case('App\Notifications\NewRequest')
        <div class="relative flex items-center rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4" @click="Livewire.navigate('{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-14 h-14 ml-3">
            </div>
            <div class="flex w-60 flex-col overflow-hidden">
                <span class="text-wrap">{{$notification->data['name']}}</span>
                <span>Sent a Request</span>
                <span class="truncate">Concerns: {{$notification->data['concerns']}}</span>
                <div class="text-sm text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
        </div>
        @break

        @case('App\Notifications\RequestStatus')
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
        @break

        @case('App\Notifications\FeedbackRating')
        <div class="relative flex items-center  rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full p-4" wire:click="opened('{{$notification->id}}', '{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-14 h-14 ml-3">
            </div>
            <div class="flex w-60 flex-col overflow-hidden truncate ">
                <span class="text-wrap">{{$notification->data['name']}} sent rate and feedback</span>
                <div>rate: {{$notification->data['rate']}}</div>
                <div>Feedback:{{$notification->data['feedback']}}</div>
                <div class="text-sm hidden md:block text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>
        </div>
        @break

        @case('App\Notifications\AssingedRequest')
        <div class="relative flex items-center  rounded-md pl-2 bg-blue/10 h hover:bg-blue/20 w-full  " wire:click="opened('{{$notification->id}}', '{{$notification->data['redirect']}}')">
            <div class="rounded-full p-3">
                <img src="{{asset('storage/'. $notification->data['img'])}}" alt=""
                    class="rounded-full w-[64px] md:h-[64px] h-[32px]">
            </div> 
            <div class="flex w-60 flex-col overflow-hidden truncate ">
                <span>You have been assigned</span>
                <span> to handle</span>
                <span class="text-wrap">{{$notification->data['name']}} 's</span>
                <span>request.</span>
                <div>Category:{{$notification->data['category']}}</div>
                <div class="text-sm hidden md:block text-blue">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            </div>

        </div>
        @break

        @endswitch

        @endforeach

    </div>
</div>
@endvolt