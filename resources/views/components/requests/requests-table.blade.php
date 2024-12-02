<div class="table-container md:block hidden w-full over">
    <table class="min-w-full break-all">
        <thead class="table-header">
            <tr>
                <th class="table-header-cell">Date</th>
                <th class="table-header-cell relative">
                    <div @click="status = !status" x-data="{ status: false }" class="flex flex-row items-center justify-center cursor-pointer">
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
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/request?status=all" class="w-full">All</a>
                                </li>
                                @if(session('user')['role'] != 'Technical Staff')
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/request?status=waiting" class="w-full">Waiting</a>
                                </li>
                                @endif
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/request?status=pending" class="w-full">Pending</a>
                                </li>
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/request?status=ongoing" class="w-full">Ongoing</a>
                                </li>
                                <li class="dropdown-open-items">
                                    <a wire:navigate.hover href="/request?status=resolved" class="w-full">Resolved</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </th>
                <th class="table-header-cell">Category</th>
                <th class="table-header-cell">Concerns</th>
                <th class="table-header-cell">Location</th>
            </tr>
        </thead>
        <tbody>
            @if($this->viewRequest()->isEmpty())
            <tr class="text-center">
                <td>N/A</td>
            </tr>

            @else
            @foreach ($this->viewRequest() as $request)

            @php
            // Define priority color
            $priorityColor = '';

            //for technical staff only
            if (session('user')['role'] == 'Technical Staff') {
            //if level 1 == red
            //if level 2 == yellow
            //if level 1 == green
            $priorityColor = $request->priorityLevel == 1 ? 'bg-red-500' :
            ($request->priorityLevel == 2 ? 'bg-yellow' :
            ($request->priorityLevel == 3 ? 'bg-green-500' : ''));
            }

            @endphp

            <tr class="table-row-cell hover:bg-blue-100 hover:border-y-blue-600 cursor-pointer"
                @click="Livewire.navigate('/request/{{$request->id }}')">

                <td class="table-row-cell">{{ $request->created_at->format('Y-m-d') }}</td>
                <td class="table-row-cell">{{ $request->status }}</td>
                <td class="table-row-cell">{{ $request->category->name }}</td>
                <td class="table-row-cell">{{ $request->concerns }}</td>
                <td class="table-row-cell text-small">
                    {{ $request->faculty->college }}
                    {{ $request->faculty->building }}
                    {{ $request->faculty->room }}
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>




<div class="table-container block md:hidden z-10" x-data="{ openReq: '' }">
    <table class="min-w-full relative  break-all">
        @foreach ($this->viewRequest() as $request)
        <tr class="table-row-cell"
            @click="openReq = openReq === '{{ $request->id }}' ? '' : '{{ $request->id }}'">
            <td class="y border mb-2 bg-blue-100">
                <span class="bg-blue-500 text-white">id: {{ $request->id }}</span>
                <span class="text-ellipsis overflow-hidden">Concerns: {{ $request->concerns }}</span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 absolute right-1 text-blue-50">
                    <path x-show="openReq == '' " stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    <path x-show="openReq" stroke-linecap="round" stroke-linejoin="round"
                        d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>


                <div class="y h-fit" x-show="openReq === '{{ $request->id }}'">

                    <div>ID: <span>{{ $request->id }}</span> </div>
                    <div>Date:<span>{{ $request->created_at->format('Y-m-d') }}</span> </div>
                    <div>Status:<span>{{ $request->status }}</span> </div>
                    <div>Category: <span>{{ $request->category->name }}</span></div>
                    <div>Concerns: <span>{{ $request->concerns }}</span></div>

                </div>
            </td>
        </tr>
        @endforeach
    </table>

</div>