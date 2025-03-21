<!-- User Table for Larger Screens -->
<div class="table-container md:block hidden w-full p-2 rounded-md"
    style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);" x-data="{ search: '' }">
    <!-- Search Input -->
  
    <div class="m-0 my-4 relative w-60 flex items-center">
        <input
            type="text"
            placeholder="Search..."
            x-model="search"
            class="w-full rounded p-2 pl-3 pr-10 input relative" />

        <!-- Search Icon/Text Inside Input -->
        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#B7B7B7">
                <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
            </svg>
        </span>
    </div>

    <table class="table-container w-full text-[100%] break-words" x-data="{ openRequest: false }">
        <thead class="table-header rounded-md hidden md:table-header-group " style="background-color: #2e5e91;">
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
            @foreach ($this->status == 'resolved' ? $this->viewRequest()->where('status', 'resolved') : $this->viewRequest()->where('status' , '!=', 'resolved') as $request)

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
                    {{request()->query('status')}}
                </td>
                @endif
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->created_at->format('Y-m-d') }}
                </td>
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ ucfirst($request->status) }}
                </td>
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->category->name }}
                </td>
                <td class="table-row-cell" @click="Livewire.navigate('/request/{{$request->id }}')">
                    {{ $request->concerns }}  
                </td>
                <td class="table-row-cell text-small">
                    {{ $request->location}}
                </td>

                @if(session('user')['role'] == 'Faculty')
                <td class="table-row-cell flex items-center justify-center">
                    @if($request->status == 'waiting')
                    <div @click="if (confirm('Are you sure you want to delete this request?')) $wire.deleteRequest({{ $request->id }})">
                        <x-icons.delete />
                    </div>
                    @endif
                </td>
                @endif
            </tr>

            

            @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- User Table for Mobile Screens -->
<div class="table-container md:hidden w-full h-auto p-2 rounded-md" x-data="{ openRequest: '', search: '' }">
    <!-- Search Input -->
    <div class="mb-4">
        <input 
            type="text" 
            placeholder="Search..." 
            x-model="search"
            class="border rounded p-2 w-full text-gray-900"
        />
    </div>

    <!-- Mobile View for Table Rows -->
    <div class="space-y-3">
        @foreach ($this->viewRequest() as $request)
            <div 
                class="border rounded bg-white shadow-md p-4"
                x-show="search === '' || 
                '{{ $request->faculty->user->name ?? '' }} {{ $request->status }} {{ $request->category->name }}'
                    .toLowerCase().includes(search.toLowerCase())"
            >
                <div class="flex justify-between">
                    <div class="font-semibold text-gray-900">Name:</div>
                    <div class="text-gray-900">{{ $request->faculty->user->name }}</div>
                </div>
                <div class="flex justify-between">
                    <div class="font-semibold text-gray-900">Date:</div>
                    <div class="text-gray-900">{{ $request->created_at->format('Y-m-d') }}</div>
                </div>
                <div class="flex justify-between">
                    <div class="font-semibold text-gray-900">Status:</div>
                    <div class="text-gray-900">{{ ucfirst($request->status) }}</div>
                </div>
                <div class="flex justify-between">
                    <div class="font-semibold text-gray-900">Category:</div>
                    <div class="text-gray-900">{{ $request->category->name }}</div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="Livewire.navigate('/request/{{$request->id}}')" 
                        class="text-white text-sm px-4 py-2 rounded-md" 
                        style="background-color: #2e5e91;">
                        View
                    </button>
                    @if(session('user')['role'] == 'Faculty')
                    <button @click="if (confirm('Are you sure you want to delete this request?')) $wire.deleteRequest({{ $request->id }})" 
                        class="text-white bg-red-500 p-2 rounded-md text-sm">
                        Delete
                    </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
