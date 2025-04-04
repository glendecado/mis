<?php

use App\Models\User;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{computed, mount, on, state};

state(['user']);

mount(function () {

    $this->user = User::find(session('user')['id']);
});

$opened = function ($id, $req) {

    $notification = Cache::flexible('unread_notif_' . $id, [5, 10], function () use ($id) {
        return $this->user->unreadNotifications->firstWhere('id', $id);
    });

    if ($notification) {
        $notification->markAsRead();
        Cache::forget('unread_notif_' . $id);
    }

    $this->redirect($req);
};

?>

<div x-data="{notif: false }" class="relative" wire:poll>
    <!-- Notification Bell -->
    <button @click="notif = !notif" class="relative p-2 rounded-full transition-all hover:bg-white/10 focus:outline-none">
        <x-icons.bell class="size-7 text-white" />
        @if($user->unreadNotifications->count() > 0)
        <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white shadow-md animate-pulse">
            {{$user->unreadNotifications->count()}}
        </span>
        @endif
    </button>

    <!-- Notification Panel -->
    <div
        x-cloak
        x-show="notif"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        @click.outside="notif = false"
        class="absolute right-1 translate-x-24 mt-3 w-72 md:w-96 bg-white rounded-xl shadow-xl ring-1 ring-gray-200 overflow-hidden z-50 max-h-[32rem] flex flex-col">
        <!-- Header -->
        <div class="px-4 py-3 bg-blue text-white">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-lg">Notifications</h3>
                @if($user->unreadNotifications->count() > 0)
                <span class="px-2 py-0.5 bg-white/20 rounded-full text-xs">
                    {{$user->unreadNotifications->count()}} new
                </span>
                @endif
            </div>
        </div>

        <!-- Notification List -->
        <div class="overflow-y-auto divide-y divide-gray-100">
            @if($user->notifications->count() === 0)
            <div class="p-6 text-center text-gray-500">
                <p>No notifications yet</p>
            </div>
            @else
            <!-- Unread Notifications -->
            @foreach ($user->notifications->whereNull('read_at') as $notification)
            @include('components.notification-item', [
            'notification' => $notification,
            'isUnread' => true,
            'wireClick' => "opened('{$notification->id}', '{$notification->data['redirect']}')"
            ])
            @endforeach

            <!-- Read Notifications -->
            @foreach ($user->notifications->whereNotNull('read_at') as $notification)
            @include('components.notification-item', [
            'notification' => $notification,
            'isUnread' => false,
            'wireClick' => "opened('{$notification->id}', '{$notification->data['redirect']}')"
            ])
            @endforeach

            @endif
        </div>
    </div>

    @script
    <script>
        let userId = {{session('user')['id']}}
        Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                $wire.$refresh();
                
            });
            Echo.leaveChannel(`App.Models.User.${userId}`); 
    </script>
    @endscript

</div>