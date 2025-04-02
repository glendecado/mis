<!-- User Management Dashboard -->
<div class="w-full" x-data="{ search: '', activeDropdown: null }">
    <!-- Search and Filters Bar -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6 p-2">
        <!-- Search Input -->
        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input
                type="text"
                x-model="search"
                placeholder="Search users..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 placeholder-gray-400 transition duration-150"
            />
        </div>
        
        <!-- Filter Buttons (Mobile) -->
        <div class="md:hidden flex gap-2 w-full">
            <button @click="activeDropdown = activeDropdown === 'role' ? null : 'role'" class="flex items-center gap-1 px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 text-sm">
                <span>Role</span>
                <svg :class="{'rotate-180': activeDropdown === 'role'}" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <button @click="activeDropdown = activeDropdown === 'status' ? null : 'status'" class="flex items-center gap-1 px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 text-sm">
                <span>Status</span>
                <svg :class="{'rotate-180': activeDropdown === 'status'}" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <!-- Mobile Dropdowns -->
        <div class="md:hidden w-full space-y-2" x-show="activeDropdown">
            <div x-show="activeDropdown === 'role'" class="bg-white border border-gray-200 rounded-lg shadow-lg p-2">
                <a href="/user?roles=all" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">All Roles</a>
                <a href="/user?roles=technicalStaff" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Technical Staff</a>
                <a href="/user?roles=faculty" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Faculty</a>
            </div>
            <div x-show="activeDropdown === 'status'" class="bg-white border border-gray-200 rounded-lg shadow-lg p-2">
                <button wire:click="$set('status', 'all')" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">All Statuses</button>
                <button  class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Active</button>
                <button wire:click="$set('status', 'inactive')" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Inactive</button>
            </div>
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 ">
        <div class="">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            <div class="flex items-center group">
                                <span>Role</span>
                                <div x-data="{ open: false }" class="relative ml-1">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-100">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-48 bg-white rounded-md shadow-lg py-1">
                                        <a href="/user?roles=all" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Roles</a>
                                        <a href="/user?roles=technicalStaff" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Technical Staff</a>
                                        <a href="/user?roles=faculty" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Faculty</a>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            <div class="flex items-center group">
                                <span>Status</span>
                                <div x-data="{ open: false }" class="relative ml-1">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-100">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-48 bg-white rounded-md shadow-lg py-1">
                                        <button wire:click="$set('status', 'all')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Statuses</button>
                                        <button wire:click="$set('status', 'active')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Active</button>
                                        <button wire:click="$set('status', 'inactive')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Inactive</button>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-100 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($this->viewUser()->when($status !== 'all', fn($query) => $query->where('status', $status)) as $user)
                    <tr 
                        x-show="search === '' || 
                            '{{ $user->id }} {{ $user->name }} {{ $user->role }} {{ $user->email }}'
                                .toLowerCase().includes(search.toLowerCase())"
                        class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ asset('storage/'.$user->img)}}" alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role === 'faculty' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button @click="Livewire.navigate('/profile/{{$user->id}}')" class="text-blue-600 hover:text-blue-900">View</button>
                                <button 
                                    @click="
                                        if (confirm('Are you sure you want to {{ $user->status === 'active' ? 'deactivate' : 'activate' }} this user?')) {
                                            $wire.userUpdateUser({{$user->id}});
                                        }
                                    "
                                    class="{{ $user->status === 'active' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                                    {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @foreach ($this->viewUser() as $user)
        <div 
            x-show="search === '' || 
                '{{ $user->id }} {{ $user->name }} {{ $user->role }} {{ $user->email }}'
                    .toLowerCase().includes(search.toLowerCase())"
            class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4">
            <div class="flex items-center space-x-4">
                <img class="h-12 w-12 rounded-full" src="{{ asset('storage/'.$user->img)}}" alt="{{ $user->name }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                    <p class="text-sm text-gray-100 truncate">{{ $user->email }}</p>
                </div>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
            
            <div class="mt-3 flex items-center justify-between">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $user->role === 'faculty' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $user->role }}
                </span>
                
                <div class="flex space-x-2">
                    <button @click="Livewire.navigate('/profile/{{$user->id}}')" class="text-sm px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        View
                    </button>
                    <button 
                        @click="
                            if (confirm('Are you sure you want to {{ $user->status === 'active' ? 'deactivate' : 'activate' }} this user?')) {
                                $wire.userUpdateUser({{$user->id}});
                            }
                        "
                        class="text-sm px-3 py-1 border rounded-md 
                            {{ $user->status === 'active' ? 'border-red-300 text-red-700 bg-white hover:bg-red-50' : 'border-green-300 text-green-700 bg-white hover:bg-green-50' }}">
                        {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>