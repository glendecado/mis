<?php

use App\Models\Request;
use App\Models\TechnicalStaff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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

    $categories = '';

    $this->totalAssignedRequests = Cache::flexible("assigned_requests_count_{$this->techId}", [5, 10], function () {
        return Request::where('assigned_requests.technicalStaff_id', $this->techId)
            ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
            ->count();
    });

    $this->totalRequestsCompleted = Cache::flexible("completed_requests_count_{$this->techId}", [5, 10], function () {
        return Request::where('assigned_requests.technicalStaff_id', $this->techId)
            ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
            ->where('requests.status', 'resolved')
            ->count();
    });

    $this->totalRatings = Cache::flexible("average_ratings_{$this->techId}", [5, 10], function () {
        return Request::where('assigned_requests.technicalStaff_id', $this->techId)
            ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
            ->where('requests.status', 'resolved')
            ->avg('rate') ?? 0;
    });

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

    $date = session('date') ?? $this->date;
    $id = $this->techId;
    $carbon = Carbon::now();
    $request = Request::query()
        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
        ->where('assigned_requests.technicalStaff_id', $id);

    if (DB::connection()->getName() == 'mysql') {
        switch ($date) {
            case '':
            case 'today':
                $request->whereDate('assigned_requests.created_at', Carbon::today())
                    ->select(
                        DB::raw("DATE_FORMAT(assigned_requests.created_at, '%h:%i %p') as date"),
                        DB::raw('COUNT(*) as total_assigned_requests'),
                        DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                    )
                    ->groupBy(DB::raw("date"))
                    ->orderBy(DB::raw("date"), 'ASC');
                break;

            case 'this_week':
                $request->where('assigned_requests.created_at', '>=', Carbon::now()->subWeek())
                    ->select(
                        DB::raw("DATE_FORMAT(assigned_requests.created_at, '%Y-%m-%d') as date"),
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
                        DB::raw("CONCAT(YEAR(assigned_requests.created_at), '-', LPAD(MONTH(assigned_requests.created_at), 2, '0'), ' week ', 
                            WEEK(assigned_requests.created_at, 0) - 
                            WEEK(DATE_SUB(assigned_requests.created_at, INTERVAL DAY(assigned_requests.created_at)-1 DAY), 0) + 1
                            ) AS date"),
                        DB::raw('COUNT(*) as total_assigned_requests'),
                        DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                    )
                    ->groupBy(DB::raw("date"))
                    ->orderBy(DB::raw("date"), 'ASC');
                break;
        }
    } else {
        switch ($date) {
            case '':
            case 'today':
                $request->whereDate('assigned_requests.created_at', Carbon::today())
                    ->select(
                        DB::raw("strftime('%H:%M', assigned_requests.created_at) as date"),
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
                        DB::raw("strftime('%Y-%m', assigned_requests.created_at) || ' week ' || 
                            (strftime('%W', assigned_requests.created_at) - 
                            strftime('%W', date(assigned_requests.created_at, 'start of month')) + 1
                            ) AS date"),
                        DB::raw('COUNT(*) as total_assigned_requests'),
                        DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                    )
                    ->groupBy(DB::raw("date"))
                    ->orderBy(DB::raw("date"), 'ASC');
                break;
        }
    }

    return $request->whereBetween('assigned_requests.created_at', [$carbon->startOfMonth()->toDateTimeString(), $carbon->endOfMonth()->toDateTimeString()])->get();
};


?>

<div class="px-10 py-6">


    <div wire:loading wire:target="addUser" class="w-full h-dvh">
        <div class="fixed inset-0 w-full h-svh bg-black/50 z-[100] flex items-center justify-center">
            <x-loaders.b-square />
        </div>
    </div>



    <div name="select" class="flex w-full gap-2">
        <!-- Date Selection -->

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



    <div class="px-10 py-6">
        <!-- Performance Summary Cards -->
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6 px-2">Staff Performance Overview</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5" x-data="{ loaded: false }"
                x-init="setTimeout(() => loaded = true, 100)">

                <!-- Average Rating Card -->
                <div x-show="loaded"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Average Rating</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalRatings, 1) }}<span class="text-lg text-gray-500">/5</span></h3>
                            </div>
                            <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ ($totalRatings/5)*100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Assigned Requests Card -->
                <div x-show="loaded"
                    x-transition:enter="transition ease-out duration-300 delay-100"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Assigned Requests</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalAssignedRequests }}</h3>
                            </div>
                            <div class="p-3 rounded-full bg-green-50 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Updated today
                        </div>
                    </div>
                </div>

                <!-- Requests Completed Card -->
                <div x-show="loaded"
                    x-transition:enter="transition ease-out duration-300 delay-200"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Completed Requests</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalRequestsCompleted }}</h3>
                            </div>
                            <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $totalAssignedRequests > 0 ? round(($totalRequestsCompleted/$totalAssignedRequests)*100) : 0 }}% completion
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Completion Rate Card -->
                <div x-show="loaded"
                    x-transition:enter="transition ease-out duration-300 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Completion Rate</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $completionRate }}<span class="text-lg">%</span></h3>
                            </div>
                            <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-500 mr-2">Target: 90%</span>
                                <div class="flex-1 h-2 bg-gray-200 rounded-full">
                                    <div class="h-2 rounded-full bg-indigo-500" style="width: {{ min($completionRate, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






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


            <div id="section-to-print" class="h-[500px]">

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


    </div>

</div>