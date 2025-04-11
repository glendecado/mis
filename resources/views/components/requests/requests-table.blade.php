<!-- Request Management Dashboard -->
<div class="w-full" x-data="{ statusDropdownOpen: false }">
    <!-- Search and Filter Bar -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
        <!-- Search Input -->
        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search requests..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 placeholder-gray-400 transition duration-150" />
        </div>

        <!-- Status Filter (Mobile) -->
        <div class="md:hidden w-full">
            <button @click="statusDropdownOpen = !statusDropdownOpen"
                class="flex items-center justify-between w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 text-sm">
                <span>Filter by Status</span>
                <svg :class="{ 'rotate-180': statusDropdownOpen }" class="h-4 w-4 transition-transform"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Mobile Status Dropdown -->
            <div x-show="statusDropdownOpen" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200 z-10">
                <div class="py-1">
                    <a wire:navigate.hover href="/request?status=all"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Requests</a>
                    @if (session('user')['role'] != 'Technical Staff')
                    <a wire:navigate.hover href="/request?status=waiting"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Waiting</a>
                    @endif
                    <a wire:navigate.hover href="/request?status=pending"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pending</a>
                    <a wire:navigate.hover href="/request?status=ongoing"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ongoing</a>
                    <a wire:navigate.hover href="/request?status=resolved"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Resolved</a>
                    <a wire:navigate.hover href="/request?status=declined"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Declined</a>
                </div>
            </div>
        </div>
    </div>

    @php
    $requests =  $this->viewRequest();
    @endphp

    @if ($requests->isEmpty())
    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-hidden rounded-md min-h-96 max-h-fit truncate">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue text-white">
                    <tr>
                        @if (session('user')['role'] != 'Faculty')
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Requestor</th>
                        @endif
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Date</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            <div class="flex items-center group">
                                <span>Status</span>
                                <div x-data="{ open: false }" class="relative ml-1">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute z-10 mt-1 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-200">
                                        <a wire:navigate.hover href="/request?status=all"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All
                                            Requests</a>
                                        @if (session('user')['role'] != 'Technical Staff')
                                        <a wire:navigate.hover href="/request?status=waiting"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Waiting</a>
                                        @endif
                                        <a wire:navigate.hover href="/request?status=pending"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pending</a>
                                        <a wire:navigate.hover href="/request?status=ongoing"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ongoing</a>
                                        <a wire:navigate.hover href="/request?status=resolved"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Resolved</a>
                                        <a wire:navigate.hover href="/request?status=declined"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Declined</a>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Category</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Concerns</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Location</th>
                        @if (session('user')['role'] == 'Technical Staff')
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Priority</th>
                        @endif
                    </tr>
                </thead>
            </table>


            <!-- Empty state for both desktop and mobile -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center text-sm text-gray-500">
                No requests found
            </div>
        </div>

    </div>


    @else
    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-y-auto rounded-md min-h-96 max-h-fit">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue text-white">
                    <tr>
                        @if (session('user')['role'] != 'Faculty')
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Requestor</th>
                        @endif
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Date</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            <div class="flex items-center group">
                                <span>Status</span>
                                <div x-data="{ open: false }" class="relative ml-1">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute z-10 mt-1 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-200">
                                        <a wire:navigate.hover href="/request?status=all"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All
                                            Requests</a>
                                        @if (session('user')['role'] != 'Technical Staff')
                                        <a wire:navigate.hover href="/request?status=waiting"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Waiting</a>
                                        @endif
                                        <a wire:navigate.hover href="/request?status=pending"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pending</a>
                                        <a wire:navigate.hover href="/request?status=ongoing"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ongoing</a>
                                        <a wire:navigate.hover href="/request?status=resolved"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Resolved</a>
                                        <a wire:navigate.hover href="/request?status=declined"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Declined</a>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Category</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Concerns</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Location</th>
                        @if (session('user')['role'] == 'Technical Staff')
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">
                            Priority</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($requests as $request)
                    <tr @click="$wire.checkPriorityLevel({{ $request->id }})"
                        class="hover:bg-gray-50 transition-colors duration-150 cursor-pointer select-none">
                        @if (session('user')['role'] != 'Faculty')
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full"
                                        src="{{ asset('storage/' . $request->faculty->user->img ?? '') }}"
                                        alt="{{ $request->faculty->user->name ?? '' }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $request->faculty->user->name ?? '' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $request->faculty->department ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $request->created_at->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $request->status == 'waiting' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $request->status == 'pending' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $request->status == 'ongoing' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $request->status == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $request->status == 'declined' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                            <div class="line-clamp-2">
                                {{ $request->categories->pluck('category.name')->join(', ') }}
                                {{ $request->categories->whereNotNull('ifOthers')->pluck('ifOthers')->join(', ') }}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="line-clamp-2">{{ $request->concerns }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $request->location }}
                        </td>

                        @if (session('user')['role'] == 'Technical Staff')
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($request->priorityLevel)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $request->priorityLevel == 1 ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $request->priorityLevel == 2 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $request->priorityLevel == 3 ? 'bg-green-100 text-green-800' : '' }}">
                                {{ $request->priorityLevel == 1 ? 'High' : ($request->priorityLevel == 2 ? 'Medium' : 'Low') }}
                            </span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @foreach ($requests as $request)
        <div
            class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4 transition-all hover:shadow-md">
            <div class="flex items-start space-x-4">
                @if (session('user')['role'] != 'Faculty')
                <img class="h-12 w-12 rounded-full"
                    src="{{ asset('storage/' . $request->faculty->user->img ?? '') }}"
                    alt="{{ $request->faculty->user->name ?? '' }}">
                @endif
                <div class="flex-1 min-w-0">
                    @if (session('user')['role'] != 'Faculty')
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $request->faculty->user->name ?? '' }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">{{ $request->faculty->department ?? '' }}
                    </p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">{{ $request->created_at->format('M d, Y') }}</p>

                    <div class="mt-2 flex items-center">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $request->status == 'waiting' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $request->status == 'pending' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $request->status == 'ongoing' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $request->status == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $request->status == 'declined' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($request->status) }}
                        </span>

                        @if (session('user')['role'] == 'Technical Staff' && $request->priorityLevel)
                        <span
                            class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $request->priorityLevel == 1 ? 'bg-red-100 text-red-800' : '' }}
                                {{ $request->priorityLevel == 2 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $request->priorityLevel == 3 ? 'bg-green-100 text-green-800' : '' }}">
                            {{ $request->priorityLevel == 1 ? 'High' : ($request->priorityLevel == 2 ? 'Medium' : 'Low') }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <p class="text-sm font-medium text-gray-900">Category:</p>
                <p class="text-sm text-gray-500">
                    {{ $request->categories->pluck('category.name')->join(', ') }}
                    {{ $request->categories->whereNotNull('ifOthers')->pluck('ifOthers')->join(', ') }}
                </p>
            </div>

            <div class="mt-2">
                <p class="text-sm font-medium text-gray-900">Concerns:</p>
                <p class="text-sm text-gray-500 line-clamp-2">{{ $request->concerns }}</p>
            </div>

            <div class="mt-2">
                <p class="text-sm font-medium text-gray-900">Location:</p>
                <p class="text-sm text-gray-500">{{ $request->location }}</p>
            </div>

            @if ($request->status == 'resolved' && is_null($request->rate) && session('user')['role'] == 'Faculty')
            <div class="mt-2 p-2 bg-yellow-50 rounded text-yellow-800 text-xs">
                ⚠️ Please provide a rate and feedback
            </div>
            @endif

            <div class="mt-4 flex justify-end gap-2">
                <button @click="$wire.checkPriorityLevel({{ $request->id }})"
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    View
                </button>
                @if ($request->status == 'waiting' && session('user')['role'] == 'Faculty')
                <button
                    @click="if (confirm('Are you sure you want to delete this request?')) $wire.deleteRequest({{ $request->id }})"
                    class="px-3 py-1 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                    Delete
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="w-[50vw] mt-4">
        {{ $this->viewRequest()->links() }}
    </div>
</div>

@script 
        <script>
            let userId = {{session('user')['id']}};
            Echo.private(`request-channel.${userId}`)
                .listen('RequestEvent', (e) => {
                    Livewire.dispatch('view-request');
                    Livewire.dispatch('ass-pending');
                });

            Echo.leaveChannel(`request-channel.${userId}`);
        </script>
@endscript