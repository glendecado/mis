<div>
    <div class="px-8 py-8 w-full bg-blue-900 flex items-center justify-between">
        <h1 class="text-slate-200 text-2xl font-medium">MIS Service Request System</h1>
        <div>
            <input type="text" wire:model.live="search" class="w-52">
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
    <nav class="bg-yellow-400 text-blue-950 flex flex-row  overflow-auto">

        <a href="/" wire:navigate class="flex items-center justify-center h-[56px] px-[20px] hover:text-white hover:bg-blue-900 {{$route == '/' ? 'text-white bg-blue-900' : '' }}">
            Home
        </a>

        <a href="{{ route('profile', ['user' => Auth::id()]) }}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:text-white hover:bg-blue-900 {{$route == 'profile' ? 'text-white bg-blue-900' : '' }}">
            Profile
        </a>

        <div class="h-fit w-fit">
            <a href="{{route('request')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:text-white hover:bg-blue-900 {{$route == 'request' ? 'text-white bg-blue-900' : '' }}">
                Request
                @if (Auth::user()->role == 'Mis Staff')
                <span class="relative left-0 bottom-2 text-md text-red-900" id="notif">
                    {{ $request }}

                </span>
                @endif

            </a>

        </div>

        @if (Auth::user()->role == 'Mis Staff')
        <a href=" {{route('manage-user')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:text-white hover:bg-blue-900    {{$route == 'manage-user' ? 'text-white bg-blue-900' : ''  }}">
            Users
        </a>

        <a href=" {{route('manage-category')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:text-white hover:bg-blue-900    {{$route == 'manage-category' ? 'text-white bg-blue-900' : ''  }}">
            Categories
        </a>
        @endif

        @livewire('user.log-out')
    </nav>

</div>