<?php

use App\Models\Request;
use App\Models\TechnicalStaff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{mount, on, placeholder, state};

state('techStaff');
state('techStaffDetails');
state('techId');
state('date');
state('totalAssignedRequests');
state('totalRequestsCompleted');
state('completionRate');
state('totalRatings');

placeholder('<div class="rounded-md w-full h-full z-50 flex items-center justify-center"><x-loaders.b-square /></div>');

$total = function () {
    if (!$this->techId) {
        $this->totalAssignedRequests = 0;
        $this->totalRequestsCompleted = 0;
        $this->totalRatings = 0;
        $this->completionRate = 0;
        return;
    }



    $this->totalAssignedRequests = Request::where('assigned_requests.technicalStaff_id', $this->techId)
        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
        ->count();

    $this->totalRequestsCompleted = Request::where('assigned_requests.technicalStaff_id', $this->techId)
        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
        ->where('requests.status', 'resolved')
        ->count();

    $this->totalRatings = Request::where('assigned_requests.technicalStaff_id', $this->techId)
        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
        ->where('requests.status', 'resolved')
        ->avg('rate') ?? 0;

    $this->completionRate = $this->totalAssignedRequests > 0
        ? round(($this->totalRequestsCompleted / $this->totalAssignedRequests) * 100, 2)
        : 0;

    $this->techStaffDetails = User::where('id', $this->techId)->get()->first();
};

mount(function () {
    $this->date = $this->date ?? 'today'; // Default date

    $this->techStaff = TechnicalStaff::with('user')->get();

    if ($this->techStaff->isNotEmpty()) {
        $this->techId = $this->techId ?? $this->techStaff->first()->user->id;
    } else {
        $this->techId = null;
    }

    $this->total();
});

on([
    'update' => function () {
        $this->total();
        session(['date' => $this->date]);
    },
]);

$techStaffMetrics = function () {
    if (!$this->techId) {
        return collect(); // Return empty collection if no staff selected
    }

    $date = session('date') ?? $this->date ?? 'today';
    $id = $this->techId;
    $carbon = Carbon::now();
    $request = Request::query()
        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
        ->where('assigned_requests.technicalStaff_id', $id);

        switch ($date) {
            case 'today':
                $request->whereDate('assigned_requests.created_at', Carbon::today())
                    ->select(
                        DB::raw("strftime('%H:%M %p', assigned_requests.created_at) as date"),
                        DB::raw('COUNT(*) as total_assigned_requests'),
                        DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                    )
                    ->groupBy(DB::raw("date"))
                    ->orderBy(DB::raw("date"), 'ASC');
                break;
        
            case 'this_week':
                $request->where('assigned_requests.created_at', '>=', Carbon::now()->subWeek())
                    ->select(
                        DB::raw("strftime('%Y-%m-%d', assigned_requests.created_at) as date"),
                        DB::raw('COUNT(*) as total_assigned_requests'),
                        DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                    )
                    ->groupBy(DB::raw("date"))
                    ->orderBy(DB::raw("date"), 'ASC');
                break;
        
            case 'this_month':
                $request->whereBetween('assigned_requests.created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])
                ->select(
                    DB::raw("strftime('%Y', assigned_requests.created_at) || '-' || 
                              strftime('%m', assigned_requests.created_at) || 
                              ' week ' || 
                              CAST(((julianday(assigned_requests.created_at) - 
                              julianday(DATE(assigned_requests.created_at, 'start of month'))) / 7) + 1 AS INTEGER) 
                              AS date"),
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                )
                ->groupBy(DB::raw("date"))
                ->orderBy(DB::raw("date"), 'ASC');
                break;
        }

    return $request->whereBetween('assigned_requests.created_at', [$carbon->startOfMonth()->toDateTimeString(), $carbon->endOfMonth()->toDateTimeString()])->get();
};


?>

<div class="px-2 py-6">

    <div name="select">
        <!-- Date Selection -->
        <div class="mb-2">
            <label for="date" class="font-semibold text-lg">Select Date:</label>
            <select wire:model.change="date" name="date" id="date" class="input w-full"
                @change="$dispatch('update')">
                <option value="today">Today</option>
                <option value="this_week">This Week</option>
                <option value="this_month">This Month</option>
            </select>
        </div>

        <!-- Tech Staff Selection -->
        <div class="">
            <label for="techId" class="font-semibold text-lg">Select Technical Staff:</label>
            <select wire:model.change="techId" name="techId" id="techId" class="input w-full"
                @change="$dispatch('update')" {{ empty($techStaff) ? 'disabled' : '' }}>
                @if ($techStaff->isNotEmpty())
                @foreach ($techStaff as $staff)
                <option value="{{ $staff->user->id }}">{{ $staff->user->name }}</option>
                @endforeach
                @else
                <option disabled>No Technical Staff Available</option>
                @endif
            </select>
        </div>
    </div>



    <div class="px-2 py-6">
        <!-- Performance Summary Table -->
        <div class="mt-6 bg-white p-4 rounded-md shadow-md">
            <h3 class="text-xl font-semibold mb-4">Staff Performance Summary</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left border">Metric</th>
                        <th class="p-3 text-left border">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-3 border"><strong>Average Rating</strong></td>
                        <td class="p-3 border">{{ number_format($totalRatings, 1) }} / 5</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="p-3 border"><strong>Total Assigned Requests</strong></td>
                        <td class="p-3 border">{{ $totalAssignedRequests }}</td>
                    </tr>
                    <tr>
                        <td class="p-3 border"><strong>Requests Completed</strong></td>
                        <td class="p-3 border">{{ $totalRequestsCompleted }}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="p-3 border"><strong>Completion Rate</strong></td>
                        <td class="p-3 border">{{ $completionRate }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>






        <div x-data="{view : 'table'}">

        <div class="flex mt-11 mb-4 gap-2 items-center justify-between w-full">
            <div class="flex gap-2 p-2">
                <!-- Table Icon -->
                <div 
                    class="p-2 rounded-md cursor-pointer"
                    :class="view == 'table' ? 'border-blue-600 bg-blue-50' : ''"
                    @click="view='table'">
                    <x-icons.table />
                </div>

                <!-- Chart Icon -->
                <div 
                    class="p-2 rounded-md cursor-pointer"
                    :class="view == 'chart' ? 'border-blue-600 bg-blue-50' : ''"
                    @click="view='chart'">
                    <x-icons.chart />
                </div>
            </div>


            <button class="p-2 border-blue-600 bg-blue-50 rounded-md" @click="window.print()">
                <x-icons.printer />
            </button>
        </div>



            <div id="section-to-print">

                <div id="showOnPrint">
                    <h1 class="text-2xl">
                        {{$techStaffDetails->name}}
                    </h1>
                </div>

                <h3 class="text-xl font-semibold mb-2" id="hideOnPrint">Detailed Performance Metrics</h3>
                <!-- Detailed Metrics Table -->
                <template x-if="view == 'table'">
                    <div class="bg-white p-4 rounded-md shadow-md">
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


    </div>

</div>