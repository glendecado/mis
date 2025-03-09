<!-- User Table for Larger Screens -->
<div class="table-container md:block w-full p-2 rounded-md"
    style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06); x-data="{ search: '' }">
    <!-- Search Input -->
    <div class="m-0 my-4 relative w-60 flex items-center">
    <input
        type="text"
        placeholder="Search..."
        x-model="search"
        class="w-full rounded p-2 pl-3 pr-10 input relative" />

    <!-- Search Icon/Text Inside Input -->
    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#B7B7B7"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
    </span>
    </div>

    <table class="table-container w-full text-[100%] break-words" x-data="{ openRequest: false }">
        <thead class="table-header rounded-md hidden md:table-header-group ">
            <tr>
                @if(session('user')['role'] != 'Faculty')
                <th class="table-header-cell">Name</th>
                @endif
                <th class="table-header-cell">Date</th>
                <th class="table-header-cell relative">
                    <div @click="status = !status" x-data="{ status: false }" class="flex flex-row items-center justify-center cursor-pointer flex-wrap">
                        <span>Status</span>
                        <!-- Arrow Icons -->
                        <div class="relative">
                            <div x-show="status" x-cloak>
                                <x-icons.arrow direction="up" />
                            </div>
                            <div x-show="status == false" x-cloak>
                                <x-icons.arrow direction="down" />
                            </div>
                        </div>

                        <!-- Dropdown -->
                        <div
                            x-show="status"
                            @click.away="status = false"
                            class="dropdown absolute top-full"
                            style="display: none;">
                            <ul class="text-sm text-gray-700 w-full">
                                <li class="dropdown-open-items 
                                {{ request()->input('status') == 'all' ? 'bg-blue text-white' : '' }}">
                                    <a wire:navigate href="/request?status=all" class="w-full p-5">All</a>
                                </li>

                                @if(session('user')['role'] != 'Technical Staff')

                                <li class="dropdown-open-items 
                                 {{ request()->input('status') == 'waiting' ? 'bg-blue text-white' : '' }}">
                                    <a wire:navigate href="/request?status=waiting" class="w-full p-5">Waiting</a>
                                </li>

                                @endif

                                <li class="dropdown-open-items 
                                {{ request()->input('status') == 'pending' ? 'bg-blue text-white' : '' }}">
                                    <a wire:navigate href="/request?status=pending" class="w-full p-5">Pending</a>
                                </li>


                                <li class="dropdown-open-items 
                                {{ request()->input('status') == 'ongoing' ? 'bg-blue text-white' : '' }}">
                                    <a wire:navigate href="/request?status=ongoing" class="w-full p-5">Ongoing</a>
                                </li>


                                <li class="dropdown-open-items 
                                {{ request()->input('status') == 'resolved' ? 'bg-blue text-white' : '' }}">
                                    <a wire:navigate href="/request?status=resolved" class="w-full p-5">Resolved</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </th>
                <th class="table-header-cell">Category</th>
                <th class="table-header-cell w-[20%]">Concerns</th>
                <th class="table-header-cell">Location</th>
                @if(session('user')['role'] == 'Faculty')
                <th class="table-header-cell">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if($this->viewRequest()->isEmpty())
            <tr class="text-center">
                <td colspan="6">N/A</td>
            </tr>
            @else
            @foreach ($this->viewRequest() as $request)

            @php
            $color = "";
            switch($request->priorityLevel){
            case 1:
            $color = "bg-red-500/50 hover:bg-red-500/30";
            break;
            case 2:
            $color = "bg-yellow/50 hover:bg-yellow/30";
            break;
            case 3:
            $color = "bg-green-500/50 hover:bg-green-500/30";
            break;
            }

            @endphp

            <tr
                class="{{session('user')['role'] == 'Technical Staff' ? $color : 'hover:bg-blue-100'}} table-row-cell  hover:border-y-blue-600 cursor-pointer hidden md:table-row"
                {{--Search--}}
                x-show="search === '' || 
                '{{ $request->faculty->user->name ?? '' }} {{ $request->status }} {{ $request->category->name }} {{ $request->concerns }} {{ $request->faculty->college}} {{ $request->faculty->building}} {{ $request->faculty->room}}'.toLowerCase().includes(search.toLowerCase())">
                @if(session('user')['role'] != 'Faculty')
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->faculty->user->name }}
                </td>
                @endif
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->created_at->format('Y-m-d') }}
                </td>
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->status }}
                </td>
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->category->name }}
                </td>
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->concerns }}
                </td>
                <td class="table-row-cell text-small">
                    {{ $request->faculty->college }}
                    {{ $request->faculty->building }}
                    {{ $request->faculty->room }}
                </td>

                @if(session('user')['role'] == 'Faculty')
                <td class="table-row-cell">
                    <div @click="if (confirm('Are you sure you want to delete this request?')) $wire.deleteRequest({{ $request->id }})">
                        <x-icons.delete />
                    </div>
                </td>
                @endif
            </tr>

            <tr x-cloak class="bg-blue w-full md:hidden flex mb-2  rounded-md text-white overflow-hidden"
                x-show="search === '' || 
            '{{ $request->faculty->user->name ?? '' }} {{ $request->status }} {{ $request->category->name }} {{ $request->concerns }} {{ $request->faculty->college }} {{ $request->faculty->building }} {{ $request->faculty->room }}'.toLowerCase().includes(search.toLowerCase())">

                <td class="flex flex-col m-2 w-full h-full relative" @click="openRequest = openRequest === '{{ $request->id }}' ? '' : '{{ $request->id }}'">
                    <span class="font-bold mb-2">
                        @if(session('user')['role'] == 'Faculty')
                        {{ $request->created_at->format('Y-m-d') }}
                        @else
                        {{$request->faculty->user->name}}
                        @endif
                    </span>

                    <span class="absolute right-1">
                        <div x-show="openRequest != '{{$request->id}}' ">
                            <x-icons.arrow direction="down" />
                        </div>

                        <div x-show="openRequest == '{{$request->id}}' ">
                            <x-icons.arrow direction="up" />
                        </div>
                    </span>

                    <span class="bg-white w-full h-full rounded-md text-black p-2 flex flex-col" x-show="openRequest == '{{$request->id}}' ">
                        @if(session('user')['role'] != 'Faculty')
                        <p>Date: {{$request->created_at->format('Y-m-d')}}</p>
                        @endif
                        <p>Status: {{ $request->status }}</p>
                        <p>Category: {{$request->created_at->format('Y-m-d')}}</p>
                        <p class="text-ellipsis overflow-hidden ">Concerns: {{$request->concerns}}</p>
                        <p>Location: {{$request->created_at->format('Y-m-d')}}</p>
                        <button class="button" @click="Livewire.navigate('/request/{{$request->id }}')">View</button>
                        @if(session('user')['role'] == 'Faculty')

                        <div @click="if (confirm('Are you sure you want to delete this request?')) $wire.deleteRequest({{ $request->id }})" class="absolute right-5">
                            <x-icons.delete />
                        </div>

                        @endif
                    </span>
                </td>
            </tr>




            @endforeach
            @endif
        </tbody>
    </table>
</div>