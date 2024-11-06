<!-- User Table for Larger Screens -->
<div class="table-container md:block hidden">
    <table class="min-w-full">
        <thead class="table-header">
            <tr>
                <th class="table-header-cell">UserId</th>
                <th class="table-header-cell">Name</th>
                <th class="table-header-cell">Role</th>
                <th class="table-header-cell">Email</th>
                <th class="table-header-cell">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->viewUser() as $user)
                <tr class="table-row-cell hover:bg-blue-100 hover:border-y-blue-600 ">
                    <td class="table-row-cell">{{ $user->id }}</td>
                    <td class="table-row-cell">{{ $user->name }}</td>
                    <td class="table-row-cell">{{ $user->role }}</td>
                    <td class="table-row-cell">{{ $user->email }}</td>
                    <td class="table-row-cell"><button wire:click="deleteUser({{$user->id}})">Delete</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- User Table for Mobile Screens -->
<div class="table-container block md:hidden z-10" x-data="{ openUser: '' }">
    <table class="min-w-full relative">
        @foreach ($this->viewUser() as $user)
            <tr class="table-row-cell"
                @click="openUser = openUser === '{{ $user->id }}' ? '' : '{{ $user->id }}'">
                <td class="y border mb-2 bg-blue-100">
                    <span class="bg-blue-500 text-white">UserId: {{ $user->id }}</span>
                    <span class="text-ellipsis overflow-hidden">Name: {{ $user->name }}</span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 absolute right-1 text-blue-50">
                        <path x-show="openUser != '{{$user->id}}' " stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        <path x-show="openUser =='{{$user->id}}'" stroke-linecap="round" stroke-linejoin="round"
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
