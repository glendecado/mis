<div x-data="{ search: '', statusFilter: '' }" 
    class="table-container w-full h-screen p-2 rounded-b-md md:h-[80vh]"
    style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);">

    <!-- Search & Filters Wrapper -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4 md:gap-4">

        <!-- Status Filter Buttons (Mobile Scrollable) -->
        <div class="flex gap-2 overflow-auto md:flex-wrap whitespace-nowrap">
            <span @click="statusFilter = ''"
                class="px-3 py-1 text-sm font-semibold text-white rounded-full cursor-pointer bg-gray-600">
                All Requests
            </span>
            <span @click="statusFilter = 'Waiting'"
                class="px-3 py-1 text-sm font-semibold text-white rounded-full cursor-pointer bg-amber-500">
                Waiting
            </span>
            <span @click="statusFilter = 'Pending'"
                class="px-3 py-1 text-sm font-semibold text-white rounded-full cursor-pointer bg-orange-500">
                Pending
            </span>
            <span @click="statusFilter = 'Ongoing'"
                class="px-3 py-1 text-sm font-semibold text-white rounded-full cursor-pointer bg-blue-500">
                Ongoing
            </span>
            <span @click="statusFilter = 'Resolved'"
                class="px-3 py-1 text-sm font-semibold text-white rounded-full cursor-pointer bg-green-500">
                Resolved
            </span>
            <span @click="statusFilter = 'Declined'"
                class="px-3 py-1 text-sm font-semibold text-white rounded-full cursor-pointer bg-red-500">
                Declined
            </span>
        </div>

        <!-- Search Bar -->
        <div class="relative w-full max-w-xs">
            <input type="text" placeholder="Search..." x-model="search"
                class="w-full rounded p-2 pl-3 pr-10 bg-white border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#B7B7B7">
                    <path
                        d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                </svg>
            </span>
        </div>
    </div>

    <!-- Data Table (Responsive) -->
    <div class="overflow-x-auto md:overflow-hidden">
        <table class="w-full text-[100%] break-words hidden md:table">
            <thead class="table-header rounded-md hidden md:table-header-group" style="background-color: #2e5e91;">
                <tr>
                    <th class="table-header-cell">Name</th>
                    <th class="table-header-cell">Date</th>
                    <th class="table-header-cell">Status</th>
                    <th class="table-header-cell">Category</th>
                    <th class="table-header-cell w-[20%]">Concerns</th>
                    <th class="table-header-cell">Location</th>
                </tr>
            </thead>
            <tbody>
                @if($this->viewRequest()->isEmpty())
                <!-- No Items Found -->
                <tr class="text-center">
                    <td colspan="6" class="py-4 text-gray-500">No items found.</td>
                </tr>
                @else
                @foreach ($this->viewRequest() as $request)
                <tr @click="window.location.href = '/request/{{ $request->id }}'"
                    x-show="(statusFilter === 'Resolved' ? '{{ ucfirst($request->status) }}' === 'Resolved' :
                            ('{{ ucfirst($request->status) }}' !== 'Resolved' && 
                            (statusFilter === '' || statusFilter === '{{ ucfirst($request->status) }}'))) && 
                            (search === '' || 
                            '{{ $request->faculty->user->name ?? '' }} {{ ucfirst($request->status) }} {{ $request->category->name }} {{ $request->concerns }} {{ $request->location }}'
                            .toLowerCase().includes(search.toLowerCase()))"
                    class="hover:bg-blue-100 table-row-cell border-b border-gray-300 cursor-pointer">
                    <td class="table-row-cell">{{ $request->faculty->user->name }}</td>
                    <td class="table-row-cell">{{ $request->created_at->format('Y-m-d') }}</td>
                    <td class="table-row-cell">{{ ucfirst($request->status) }}</td>
                    <td class="table-row-cell">{{ $request->category->name }}</td>
                    <td class="table-row-cell">{{ $request->concerns }}</td>
                    <td class="table-row-cell">{{ $request->location }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <!-- Mobile View (Card Layout) -->
        <div class="md:hidden space-y-3 mt-4">
            @if($this->viewRequest()->isEmpty())
            <p class="text-gray-500 text-center">No items found.</p>
            @else
            @foreach ($this->viewRequest() as $request)
            <div @click="window.location.href = '/request/{{ $request->id }}'"
                x-show="(statusFilter === 'Resolved' ? '{{ ucfirst($request->status) }}' === 'Resolved' :
                        ('{{ ucfirst($request->status) }}' !== 'Resolved' && 
                        (statusFilter === '' || statusFilter === '{{ ucfirst($request->status) }}'))) && 
                        (search === '' || 
                        '{{ $request->faculty->user->name ?? '' }} {{ ucfirst($request->status) }} {{ $request->category->name }} {{ $request->concerns }} {{ $request->location }}'
                        .toLowerCase().includes(search.toLowerCase()))"
                class="bg-white p-4 rounded-lg shadow-md border border-gray-300 cursor-pointer">
                
                <p class="text-lg font-semibold text-blue-600">{{ $request->faculty->user->name }}</p>
                <p class="text-sm text-gray-600"><strong>Date:</strong> {{ $request->created_at->format('Y-m-d') }}</p>
                <p class="text-sm text-gray-600"><strong>Status:</strong> {{ ucfirst($request->status) }}</p>
                <p class="text-sm text-gray-600"><strong>Category:</strong> {{ $request->category->name }}</p>
                <p class="text-sm text-gray-600"><strong>Concerns:</strong> {{ $request->concerns }}</p>
                <p class="text-sm text-gray-600"><strong>Location:</strong> {{ $request->location }}</p>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
