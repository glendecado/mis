<div>
    <div class="px-8 py-8 w-full bg-blue-500 flex items-center justify-between">
        <h1 class="text-white font-geist text-2xl font-medium">MIS Service Request System</h1>
        <div>
            <input type="text" wire:model.live="search" class="w-52 rounded-md">
            @if ($search)
            <div class="absolute bg-white flex flex-col w-52 ">




                @foreach ($user as $u)
                <a href=" /profile/{{$u->id}}" class="p-2 flex flex-row w-52 hover:bg-slate-500">
                    <img src="{{ asset('storage/' . $u->img) }}" alt="" class="w-[40px] h-[40px] rounded-[100%]">
                    {{$u->name}}
                </a>
                @endforeach




            </div>
            @endif
        </div>

    </div>
    <nav class="bg-yellow text-blue-900 font-geist flex flex-row  overflow-auto">

        <a href="/" wire:navigate class="flex items-center justify-center h-[56px] px-[20px] hover:text-white hover:bg-blue-500 trasition duration-200 {{$route == '/' ? 'text-white bg-blue-700' : '' }}">
            Home
        </a>

        <a href="{{ route('profile', ['user' => Auth::id()]) }}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:text-white hover:bg-blue-500 trasition duration-200 {{$route == 'profile' ? 'text-white bg-blue-700' : '' }}">
            Profile
        </a>



        <div class="h-fit w-fit">

            <a href="{{route('request')}}"
                wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:text-white hover:bg-blue-500 trasition duration-200 {{$route == 'request' || $route == 'manage-category' ? 'text-white bg-blue-700' : '' }}">
                Request
                @if (Auth::user()->role == 'Mis Staff')
                <h1 class="relative left-0 bottom-2 text-md text-red-900" id="request-count">
                    {{ $request }}

                </h1>
                @endif
            </a>

        </div>



        @if (Auth::user()->role == 'Mis Staff')

        <a href=" {{route('manage-user')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:text-white hover:bg-blue-900    {{$route == 'manage-user' ? 'text-white bg-blue-900' : ''  }}">
            Users
        </a>
        @endif

        @livewire('user.log-out')

        <div x-cloak x-data="{open : false}">
            <div class="absolute right-3 h-[56px] flex justify-center items-center">
                <button @click="open = !open" wire:click="isClicked">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="25" height="25">
                        <path d="M22.555,13.662l-1.9-6.836A9.321,9.321,0,0,0,2.576,7.3L1.105,13.915A5,5,0,0,0,5.986,20H7.1a5,5,0,0,0,9.8,0h.838a5,5,0,0,0,4.818-6.338ZM12,22a3,3,0,0,1-2.816-2h5.632A3,3,0,0,1,12,22Zm8.126-5.185A2.977,2.977,0,0,1,17.737,18H5.986a3,3,0,0,1-2.928-3.651l1.47-6.616a7.321,7.321,0,0,1,14.2-.372l1.9,6.836A2.977,2.977,0,0,1,20.126,16.815Z" />
                    </svg>
                </button>


                <div class="bg-blue-50 h-[450px] w-[300px] absolute top-[45px] right-0 z-50 rounded-md p-2 overflow-scroll"
                    x-show="open"
                    x-transition:enter="transition transform ease-out duration-300"
                    x-transition:enter-start="translate-y-[-20px] opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition transform ease-in duration-300"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="translate-y-[-20px] opacity-0"
                    @click.away="open = false">
                    <p id="notif-message">
                        @php
                        $notifMessage = Cache::get('notif-message-' . Auth::id());
                        @endphp
                        @if ($notifMessage)
                        @foreach (array_reverse($notifMessage) as $m)
                    <div id="notif">
                        <div id="notif-message">
                            {{$m['message']}}
                        </div>
                        <div id="notif-date">
                            {{$m['date']}}
                        </div>
                        <br>
                    </div>
                    @endforeach
                    @endif
                    </p>
                </div>
                @php
                $notifCount = Cache::get('notif-count-' . Auth::id());
                @endphp
                @if ($notifCount)
                <h1 class="absolute right-[10px] top-2 text-sm text-white bg-red-500 w-5 h-5 flex justify-center" id="notif-count" style="border-radius: 100%;">


                    {{$notifCount}}

                </h1>
                @endif
            </div>
        </div>

    </nav>

</div>