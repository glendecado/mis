<div x-data="{
    categoryData: {{ json_encode($categoryCounts) }},
    othersCount: {{ $othersCount ?? 0 }},
    totalRequests: {{ $totalRequests }},
    chart: null,
    
    init() {
        this.createChart();
    },
    
    createChart() {
        // Prepare data for chart
        const labels = Object.keys(this.categoryData);
        if (this.othersCount > 0) {
            labels.push('Others');
        }
        
        const data = Object.values(this.categoryData);
        if (this.othersCount > 0) {
            data.push(this.othersCount);
        }
        
        // Colors - you can customize these
        const backgroundColors = [
            '#1D77FF', '#FFCC00', '#4CAF50', '#9C27B0', 
            '#FF5722', '#607D8B', '#E91E63', '#00BCD4'
        ].slice(0, labels.length);
        
        if (window.categoryChart) window.categoryChart.destroy();
        
        const ctx = this.$refs.categoryChart.getContext('2d');
        window.categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Requests by Category',
                    data: data,
                    backgroundColor: backgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const value = context.raw;
                                const percentage = (value / this.totalRequests * 100).toFixed(1);
                                return `${value} requests (${percentage}%)`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
}">
    <div class="mt-8">
        <div class="flex items-center justify-between mb-6 px-2">
            <h3 class="text-2xl font-semibold text-gray-800">Total Assigned Categories Overview</h3>
            
            <!-- Print Button -->
            <button 
                @click="window.print()"
                class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors"
                aria-label="Print report"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Original Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5" x-data="{ loaded: false }"
                x-init="setTimeout(() => loaded = true, 100)">
                
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
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <span class="text-xs font-medium text-gray-500 mr-2">{{ $totalRequests > 0 ? round(($count/$totalRequests)*100) : 0 }}%</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full">
                                        <div class="h-2 rounded-full" style="width: {{ $totalRequests > 0 ? ($count/$totalRequests)*100 : 0 }}%"></div>
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
            
            <!-- Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <canvas x-ref="categoryChart" class="w-full" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>