<div class="mt-8">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Request Categories Overview</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5" x-data="{ loaded: false }"
        x-init="setTimeout(() => loaded = true, 100)">
        
        @php
            // Extract and remove "Others" to ensure it appears last
            $othersCount = $categoryCounts['Others'] ?? null;
            unset($categoryCounts['Others']);
            
            // Define color schemes for each category
            $categoryStyles = [
                'Computer/Laptop/Printer' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'progress' => 'bg-blue-500'],
                'Network' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'progress' => 'bg-green-500'],
                'Telephone' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'progress' => 'bg-purple-500'],
                'Software' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'progress' => 'bg-yellow-500'],
                'Others' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'progress' => 'bg-gray-500']
            ];
            
            // Calculate total requests for percentage
            $totalRequests = array_sum($categoryCounts) + ($othersCount ?? 0);
        @endphp

        @foreach($categoryForMonth as $category => $count)
            <div x-show="loaded"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ $category }}</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $count }}</h3>
                        </div>
                        <div class="p-3 rounded-full {{ $categoryStyles[$category]['bg'] }} {{ $categoryStyles[$category]['text'] }}">
                            @switch($category)
                                @case('Computer/Laptop/Printer')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    @break
                                @case('Network')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    @break
                                @case('Telephone')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    @break
                                @case('Software')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <span class="text-xs font-medium text-gray-500 mr-2">{{ $totalRequests > 0 ? round(($count/$totalRequests)*100) : 0 }}%</span>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full">
                                <div class="h-2 rounded-full {{ $categoryStyles[$category]['progress'] }}" style="width: {{ $totalRequests > 0 ? ($count/$totalRequests)*100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($othersCount)
            <div x-show="loaded"
                x-transition:enter="transition ease-out duration-300 delay-400"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Others</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $othersCount }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-gray-50 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <span class="text-xs font-medium text-gray-500 mr-2">{{ $totalRequests > 0 ? round(($othersCount/$totalRequests)*100) : 0 }}%</span>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full">
                                <div class="h-2 rounded-full bg-gray-500" style="width: {{ $totalRequests > 0 ? ($othersCount/$totalRequests)*100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>