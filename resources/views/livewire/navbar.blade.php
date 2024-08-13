<div>
    <div class="px-8 py-8 w-full bg-blue-900 flex items-center justify-between">
        <h1 class="text-slate-200 text-2xl font-medium">MIS Service Request System</h1>
        <div>
            <input type="text" wire:model.live="search" class="w-52">
            @if ($search)
            <div class="absolute bg-white flex flex-col w-52 ">




                @foreach ($user as $u)
                <a href=" /profile/{{$u->id}}" class="p-2 flex flex-row w-52 hover:bg-slate-500">
                    <img src="{{ asset('storage/' . $u->img) }}" alt="" class="w-12 rounded-[100%]"> 
                    {{$u->name}}
                </a>
                @endforeach




            </div>
            @endif
        </div>

    </div>
    <nav class="bg-blue-950 text-white flex flex-row gap-2 overflow-auto">

        <a href="/" wire:navigate class="flex items-center justify-center h-[56px] px-[20px] hover:bg-yellow-400 hover:text-blue-950 {{$route == '/' ? 'bg-yellow-400 text-blue-950' : '' }}">
            Home
        </a>

        <a href="{{ route('profile', ['user' => Auth::id()]) }}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'profile' ? 'bg-yellow-400 text-blue-950' : '' }}">
            Profile
        </a>

        <div class="h-fit w-fit">
            <a href="{{route('request')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'request' ? 'bg-yellow-400 text-blue-950' : '' }}">
                Request
                @if (Auth::user()->role == 'Mis Staff')
                <span class="relative left-0 bottom-2 text-md text-red-900" id="notif">
                    {{ $request }}

                </span>
                @endif

            </a>

        </div>

        @if (Auth::user()->role == 'Mis Staff')
        <a href="{{route('manage-user')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'manage-user' ? 'bg-yellow-400 text-blue-950' : '' }}">
            Users
        </a>
        @endif

        @livewire('user.log-out')
    </nav>

</div>