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

        <div class="absolute right-3 h-[56px] flex justify-center items-center">
            <div>notif {{--change to icon--}}</div>
            <h1 class="relative left-0 bottom-2 text-md text-red-900" id="request-count">
                @php
                $notifications = Cache::get('notif-count' . Auth::id());
                @endphp
                @if ($notifications)
                    {{$notifications}}
                @endif
            </h1>
        </div>
    </nav>

</div>