<!-- User Table for Larger Screens -->
<div class="md:block hidden w-full p-2 rounded-md" x-data="{ search: '' }">
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

    <table class="min-w-full break-all">
        <thead class="table-header" style="background-color: #2e5e91;">
            <tr>
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
                                <li class="dropdown-open-items cursor-pointer" wire:click="$set('status', 'all')">
                                    <span class="w-full p-5">All</span>
                                </li>
                                <li class="dropdown-open-items cursor-pointer" wire:click="$set('status', 'active')">
                                    <span class="w-full p-5">Active</span>
                                </li>
                                <li class="dropdown-open-items cursor-pointer" wire:click="$set('status', 'inactive')">
                                    <span class="w-full p-5">Inactive</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($this->viewUser()->when($status !== 'all', fn($query) => $query->where('status', $status)) as $user)
            <tr
                class="table-row-cell hover:bg-blue-100 hover:border-y-blue-600 cursor-pointer"
                x-show="search === '' || 
                    '{{ $user->id }} {{ $user->name }} {{ $user->role }} {{ $user->email }}'
                        .toLowerCase().includes(search.toLowerCase())">
                <td class="table-row-cell" @click="Livewire.navigate('/profile/{{$user->id}}')">{{ $user->name }}</td>
                <td class="table-row-cell" @click="Livewire.navigate('/profile/{{$user->id}}')">{{ $user->role }}</td>
                <td class="table-row-cell" @click="Livewire.navigate('/profile/{{$user->id}}')">{{ $user->email }}</td>
                <td class="table-row-cell relative  {{$user->status == 'active' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'}}"
                    @click="
                            if (confirm('Are you sure you want to make this user inactive?')) {
                                $wire.userUpdateUser({{$user->id}});
                            }
                        ">
                    <p class="text-white">{{ ucfirst($user->status) }}</p>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- User Table for Mobile Screens -->
<div class="table-container md:hidden w-full h-auto p-2 rounded-md" x-data="{ openUser: '', search: '' }">
    <!-- Search Input -->
    <div class="mb-4">
        <input
            type="text"
            placeholder="Search..."
            x-model="search"
            class="border rounded p-2 w-full text-sm md:text-base" />
    </div>

    <!-- Mobile View for Table Rows -->
    <div class="space-y-2">
        @foreach ($this->viewUser() as $user)
        <div
            class="border rounded bg-white w-full p-4 shadow-md text-sm md:text-base relative"
            x-show="search === '' || 
                '{{ $user->id }} {{ $user->name }} {{ $user->role }} {{ $user->email }}'
                    .toLowerCase().includes(search.toLowerCase())">
            <div class="flex justify-between text-sm md:text-base">
                <div class="font-semibold text-gray-800">UserId:</div>
                <div class="text-gray-700">{{ $user->id }}</div>
            </div>
            <div class="flex justify-between">
                <div class="font-semibold text-gray-800">Name:</div>
                <div class="text-gray-700">{{ $user->name }}</div>
            </div>
            <div class="flex justify-between">
                <div class="font-semibold text-gray-800">Role:</div>
                <div class="text-gray-700">{{ $user->role }}</div>
            </div>
            <div class="flex justify-between">
                <div class="font-semibold text-gray-800">Email:</div>
                <div class="text-gray-700">{{ $user->email }}</div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex justify-end gap-2 ">
                <button
                    @click="Livewire.navigate('/profile/{{$user->id}}')"
                    class="text-white text-sm px-2 py-2 rounded-md" style="background-color: #2e5e91;">
                    View
                </button>
                <button class="p-2 relative rounded-md  {{$user->status == 'active' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'}}"
                    @click="
                            if (confirm('Are you sure you want to make this user inactive?')) {
                                $wire.userUpdateUser({{$user->id}});
                            }
                        ">
                    <p class="text-white">{{ ucfirst($user->status) }}</p>
                </button>
            </div>

        </div>
        @endforeach
    </div>
</div>