<div x-data="{view : 'table'}">

<div class="flex mt-11 gap-2 items-center">

    <div :class="view == 'table' ? 'border-2 rounded-md border-blue-700 p-1' : ''" @click="view='table'">
        <x-icons.table />
    </div>

    <div :class="view == 'chart' ? 'border-2 rounded-md border-blue-700 p-1' : ''" @click="view='chart'">
        <x-icons.chart />
    </div>
    <div class="mb-2 w-full">
        <div class="float-left">
            <label for="date" class="font-semibold text-lg">Select Date:</label>
            <select wire:model.change="date" name="date" id="date" class="input w-full"
                @change="$dispatch('update')">
                <option value="today">Today</option>
                <option value="this_week">This Week</option>
                <option value="this_month">This Month</option>
            </select>
        </div>
    </div>


</div>

<button class="w-full flex justify-end" @click="window.print()">
    <x-icons.printer />
</button>


<div id="section-to-print" class="h-fit mb-8">

    <div id="showOnPrint">
        <h1 class="text-2xl">
            {{$techStaffDetails->name}}
        </h1>
    </div>



    <h3 class="text-xl font-semibold mb-4" id="hideOnPrint">Detailed Performance Metrics</h3>
    <!-- Detailed Metrics Table -->
    <template x-if="view == 'table'">
        <div class="mt-6 bg-white p-4 rounded-md shadow-md">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left border">Date/Time Period</th>
                            <th class="p-3 text-left border">Assigned Requests</th>
                            <th class="p-3 text-left border">Requests Resolved</th>
                            <th class="p-3 text-left border">Completion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->techStaffMetrics() as $metric)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                            <td class="p-3 border">{{ $metric->date ?? ($metric->year . ' Week ' . $metric->week) }}</td>
                            <td class="p-3 border">{{ $metric->total_assigned_requests }}</td>
                            <td class="p-3 border">{{ $metric->total_requests_resolved }}</td>
                            <td class="p-3 border">{{ $metric->total_assigned_requests > 0 ? round(($metric->total_requests_resolved / $metric->total_assigned_requests) * 100, 2) : 0 }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-3 border text-center">No data available for the selected period</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </template>

    <template x-if="view == 'chart' " id="section-to-print">
        <div class="flex mt-2 justify-center flex-wrap">
            <!-- Chart Display -->
            <div class="w-full max-w-3xl mx-auto h-fit" x-data="{
data: {{ json_encode($this->techStaffMetrics()) }},
chartData: { labels: [], assignedData: [], resolvedData: [] },
init() {
    if (window.myChart) window.myChart.destroy();
    this.chartData.labels = this.data.map(item => item.date ?? ``);
    this.chartData.assignedData = this.data.map(item => item.total_assigned_requests);
    this.chartData.resolvedData = this.data.map(item => item.total_requests_resolved);
    this.createChart();
},
createChart() {
    window.myChart = new Chart(this.$refs.chartCanvas, {
        type: 'bar',
        data: { labels: this.chartData.labels, datasets: [
            { label: 'Assigned Requests', data: this.chartData.assignedData, backgroundColor: '#1D77FF' },
            { label: 'Requests Resolved', data: this.chartData.resolvedData, backgroundColor: '#FFCC00' }
        ]},
        options: { responsive: true, scales: { y: { min: 0, ticks: { stepSize: 1 } } } }
    });
}
}" x-init="init">
                <canvas x-ref="chartCanvas" class="mt-2 rounded-mb border"></canvas>
            </div>
        </div>
    </template>
</div>

</div>