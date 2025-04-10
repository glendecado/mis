<x-modal name="assign-task-modal">
    <div class="w-full" x-data="{ search: '' }">
        <!-- Search Bar -->
        <div class="mb-4">
            <div class="relative w-full md:w-80">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Search staff..."
                    class="block w-full pl-10 pr-3 py-1 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 
                    text-sm placeholder-gray-400 transition duration-150 placeholder:text-sm" />
            </div>
        </div>

        @php
            $techs = $this->viewTechStaff();
        @endphp

        <!-- Desktop Table -->
        <div class="hidden md:block rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Staff Member</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-100 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($techs as $tech)
                    @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                    <tr
                        x-show="search === '' || 
                            '{{ $tech->user->id }} {{ $tech->user->name }} {{ $tech->user->email }}'
                                .toLowerCase().includes(search.toLowerCase())"
                        class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="relative">
                                    @if($tech->user->isOnline())
                                    <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full bg-green-500 ring-2 ring-white"></span>
                                    @endif
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden">
                                        <img class="h-full w-full object-cover" src="{{ asset('storage/'. $tech->user->img) }}" alt="{{ $tech->user->name }}">
                                    </div>

                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $tech->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $tech->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div wire:loading.attr="disabled">
                                <button
                                    type="button"
                                    wire:loading.attr="disabled"
                                    class="text-sm px-3 py-1 bg-blue text-white rounded-md hover:bg-blue-700 transition-colors"
                                    wire:click.prevent="assignTask('{{$tech->user->id}}')"
                            wire:confirm="Are you sure you want to assign this technical Staff?">
                                    Assign
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-3">
            @foreach($techs as $tech)
            @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
            <div
                x-show="search === '' || 
                    '{{ $tech->user->id }} {{ $tech->user->name }} {{ $tech->user->email }}'
                        .toLowerCase().includes(search.toLowerCase())"
                class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4">
                <div class="flex items-center space-x-4">

                    <div class="relative">
                        @if($tech->user->isOnline())
                        <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full bg-green-500 ring-2 ring-white"></span>
                        @endif

                        <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden ">
                            <img class="h-full w-full object-cover" src="{{ asset('storage/'.$tech->user->img) }}" alt="{{ $tech->user->name }}">
                        </div>

                    </div>


                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $tech->user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $tech->user->email }}</p>
                    </div>
                </div>

                <div class="mt-3 flex justify-end">
                    <div wire:loading.attr="disabled">
                        <button
                            type="button"
                            wire:loading.attr="disabled"
                            class="text-sm px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"

                            wire:click.prevent="assignTask('{{$tech->user->id}}')"
                            wire:confirm="Are you sure you want to assign this technical Staff?">
                            Assign
                        </button>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</x-modal>