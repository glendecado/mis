<!-- User Table for Larger Screens -->
<div class="table-container md:block hidden w-full p-2 rounded-md" x-data="{ search: '' }">
    <!-- Search Input -->
    <div class="m-4">
        <input 
            type="text" 
            placeholder="Search..." 
            x-model="search"
            class="input w-96"
        />
    </div>

    <table class="w-full text-[100%] break-all">
        <thead class="table-header">
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
                class="{{session('user')['role'] == 'Technical Staff' ? $color : 'hover:bg-blue-100'}} table-row-cell  hover:border-y-blue-600 cursor-pointer" 
                {{--Search--}}
                x-show="search === '' || 
                '{{ $request->faculty->user->name ?? '' }} 
                {{ $request->status }} 
                {{ $request->category->name }} 
                {{ $request->concerns }} 
                {{ $request->faculty->college}}
                {{ $request->faculty->building}}
                {{ $request->faculty->room}}
                 '
                    .toLowerCase().includes(search.toLowerCase())"
            >
                @if(session('user')['role'] != 'Faculty')
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->faculty->user->name }}
                    {{$request->priorityLevel}}
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
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- User Table for Mobile Screens with Search -->
<div class="table-container block md:hidden z-10 p-4" x-data="{ openRequest: '', search: '' }">
    <!-- Search Input -->
    <div class="m-4">
        <input 
            type="text" 
            placeholder="Search..." 
            x-model="search"
            class="input"
        />
    </div>

    <table class="min-w-full relative p-2">
        @foreach ($this->viewRequest() as $request)
        <tr class="table-row-cell"
            x-show="search === '' || 
            '{{ $request->faculty->user->name ?? '' }} {{ $request->status }} {{ $request->category->name }} {{ $request->concerns }}'
                .toLowerCase().includes(search.toLowerCase())"
            @click="openRequest = openRequest === '{{ $request->id }}' ? '' : '{{ $request->id }}'">
            <td class="y border mb-2 bg-blue-100 rounded-md">
                <span class="bg-blue rounded-md text-white">RequestId: {{ $request->id }}</span>
                <span class="text-ellipsis overflow-hidden">Name: {{ $request->faculty->user->name }}</span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 absolute right-1 text-blue-50">
                    <path x-show="openRequest != '{{$request->id}}' " stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    <path x-show="openRequest =='{{$request->id}}'" stroke-linecap="round" stroke-linejoin="round"
                        d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                <div class="y h-fit" x-show="openRequest === '{{ $request->id }}'" >
                    <div>Status: <span>{{ $request->status }}</span></div>
                    <div>Category: <span>{{ $request->category->name }}</span></div>
                    <div>Concerns: <span>{{ $request->concerns }}</span></div>
                    <div>Location: <span>{{ $request->faculty->college }} {{ $request->faculty->building }} {{ $request->faculty->room }}</span></div>
                    @if(session('user')['role'] == 'Faculty')
                    <button @click="if (confirm('Are you sure you want to delete this request?')) $wire.deleteRequest({{ $request->id }})">
                        <x-icons.delete />
                    </button>
                    @endif
                    <div @click="Livewire.navigate('/request/{{$request->id }}')" class="bg-yellow text-blue-2 h-7">view</div>
                </div>

            </td>
        </tr>
        @endforeach
    </table>
</div>
