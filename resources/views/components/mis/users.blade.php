<!-- User Table for Larger Screens -->
<div class="table-container md:block hidden w-full p-2 rounded-md" x-data="{ search: '' }">
    <!-- Search Input -->
    <div class="m-0 my-4 relative w-60 flex items-center">
    <input
        type="text"
        placeholder="Search..."
        x-model="search"
        class="w-full border rounded p-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 relative" />

    <!-- Search Icon/Text Inside Input -->
    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#B7B7B7"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
    </span>
    </div>

    <table class="min-w-full break-all">
        <thead class="table-header">
            <tr>
                <th class="table-header-cell">UserId</th>
                <th class="table-header-cell">Name</th>
                <th class="table-header-cell relative">
                    <div @click="role = !role" x-data="{ role: false }" class="flex flex-row items-center justify-center cursor-pointer">
                        <span>Role</span>
                        <!-- Arrow Icons -->
                        <div class="relative">
                            <div x-show="role" x-cloak>
                                <x-icons.arrow direction="up" />
                            </div>
                            <div x-show="role == false" x-cloak>
                                <x-icons.arrow direction="down" />
                            </div>
                        </div>

                        <!-- Dropdown -->
                        <div
                            x-show="role"
                            @click.away="role = false"
                            class="dropdown absolute top-full"
                            style="display: none;">
                            <ul class="text-sm text-gray-700 w-full">
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/user?roles=all" class="w-full p-5">All</a>
                                </li>
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/user?roles=technicalStaff" class="w-full p-5">Technical Staff</a>
                                </li>
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/user?roles=faculty" class="w-full p-5">Faculty</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </th>
                <th class="table-header-cell">Email</th>
                <th class="table-header-cell">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->viewUser() as $user)
                <tr 
                    class="table-row-cell hover:bg-blue-100 hover:border-y-blue-600 cursor-pointer"
                    x-show="search === '' || 
                    '{{ $user->id }} {{ $user->name }} {{ $user->role }} {{ $user->email }}'
                        .toLowerCase().includes(search.toLowerCase())"
                >
                    <td class="table-row-cell" @click="Livewire.navigate('/profile/{{$user->id}}')">{{ $user->id }}</td>
                    <td class="table-row-cell" @click="Livewire.navigate('/profile/{{$user->id}}')">{{ $user->name }}</td>
                    <td class="table-row-cell" @click="Livewire.navigate('/profile/{{$user->id}}')">{{ $user->role }}</td>
                    <td class="table-row-cell" @click="Livewire.navigate('/profile/{{$user->id}}')">{{ $user->email }}</td>
                    <td class="table-row-cell">
                        <button @click="if (confirm('Are you sure you want to delete this user?')) $wire.deleteUser({{ $user->id }})">
                            <x-icons.delete />
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- User Table for Mobile Screens -->
<div class="table-container block md:hidden z-10" x-data="{ openUser: '', search: '' }">
    <!-- Search Input -->
    <div class="mb-4">
        <input 
            type="text" 
            placeholder="Search..." 
            x-model="search"
            class="border rounded p-2 w-full"
        />
    </div>

    <table class="min-w-full relative">
        @foreach ($this->viewUser() as $user)
            <tr 
                class="table-row-cell"
                @click="openUser = openUser === '{{ $user->id }}' ? '' : '{{ $user->id }}'"
                x-show="search === '' || 
                '{{ $user->id }} {{ $user->name }} {{ $user->role }} {{ $user->email }}'
                    .toLowerCase().includes(search.toLowerCase())"
            >
                <td class="y border mb-2 bg-blue-100">
                    <span class="bg-blue-500 text-white">UserId: {{ $user->id }}</span>
                    <span class="text-ellipsis overflow-hidden">Name: {{ $user->name }}</span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 absolute right-1 text-blue-50">
                        <path x-show="openUser != '{{$user->id}}'" stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        <path x-show="openUser == '{{$user->id}}'" stroke-linecap="round" stroke-linejoin="round"
                            d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <div class="y h-fit" x-show="openUser === '{{ $user->id }}'">
                        <div>UserId: <span>{{ $user->id }}</span></div>
                        <div>Name: <span>{{ $user->name }}</span></div>
                        <div>Role: <span>{{ $user->role }}</span></div>
                        <div>Email: <span>{{ $user->email }}</span></div>
                        <button wire:click="deleteUser({{$user->id}})">Delete</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>
