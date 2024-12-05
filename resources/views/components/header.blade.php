<header class="header">

    @php
    $user = App\Models\User::find(session('user')['id']);
    @endphp

    {{--Logo--}}
    <div class="header-container-logo"
        @click="Livewire.navigate('/request?status=all')">
        <x-logo />
        <span class="hidden md:block">MIS Service Request Portal</span>
    </div>


    {{--profile--}}
    <div class="x gap-2 items-center cursor-pointer">
        <div x-data="{notif: false}">

            <div @click="notif = !notif">
                <x-icons.bell class="size-10 p-2 text-white border rounded-full" />
            </div>


            <div  id="ntf" x-cloak x-show="notif" class="dropdown absolute flex flex-col gap-4 top-16 h-96 overflow-y-auto px-4 w-80 right-6 pt-5"
                x-init="Echo.private('App.Models.User.' + {{session('user')['id']}}).notification((notification) => {
            console.log(notification.message); // Log the message
            console.log(notification.redirect); // Log the redirect URL
            const notificationList = document.querySelector('#ntf');
            const newNotif = `<div><a href=\'${notification.redirect}\'>${notification.message}</a><span class=\'text-[13px]\'>Date Created: ${new Date().toLocaleString()}</span></div>`;
            notificationList.innerHTML = newNotif  + notificationList.innerHTML;
            });">


                @foreach ($user->notifications as $notification)
                <div>
                    <a href="{{ $notification->data['redirect'] }}">
                        {{ $notification->data['message'] }}
                    </a>
                    <span class="text-[13px]"> Date Created: {{ $notification->created_at->format('Y-m-d H:i:s') }}</span>
                </div>


                @endforeach

            </div>
        </div>


        <div class="header-container-profile " x-data="{open : false}" @click="open = !open">

            <span class="">{{session('user')['role']}}</span>

            <img src="{{ asset('storage/' . session('user')['img']) }}" alt=""
                class="rounded-full size-10">

            {{--arrow--}}
            <div x-show="open == false">
                <x-icons.arrow direction="down" />
            </div>

            {{--open dropdown--}}
            <div x-show="open == true" x-cloak @click.outside="open = false">

                <x-icons.arrow direction="up" />

                <div class="dropdown right-7 top-16 absolute">

                    <div class="dropdown-open-items" @click="Livewire.navigate('/profile/{{session('user')['id']}}')">
                        <x-icons.profile class="size-6 absolute left-5" />
                        <span>Profile</span>
                    </div>


                    <livewire:user.logout />


                </div>
            </div>

        </div>
    </div>

</header>