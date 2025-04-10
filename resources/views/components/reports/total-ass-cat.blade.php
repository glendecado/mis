<div class="mt-8">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6 px-2">Total Assigned Categories Overview</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5" x-data="{ loaded: false }"
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

        @foreach($categoryCounts as $category => $count)
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