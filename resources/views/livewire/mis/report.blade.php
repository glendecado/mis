<?php

use App\Models\Request;
use App\Models\TechnicalStaff;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{mount, on, placeholder, state};

state('techStaff');
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
    },
]);

$techStaffMetrics = function () {
    if (!$this->techId) {
        return collect(); // Return empty collection if no staff selected
    }

    $date = $this->date;
    $id = $this->techId;
    $carbon = Carbon::now();
    $request = Request::query()
        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
        ->where('assigned_requests.technicalStaff_id', $id);

    switch ($date) {
        case 'today':
            $request->whereDate('assigned_requests.created_at', Carbon::today())
                ->select(
                    DB::raw("DATE_FORMAT(assigned_requests.created_at, '%Y-%m-%d %H') as date"),
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                )
                ->groupBy(DB::raw("DATE_FORMAT(assigned_requests.created_at, '%Y-%m-%d %H')"))
                ->orderBy(DB::raw("DATE_FORMAT(assigned_requests.created_at, '%Y-%m-%d %H')"), 'ASC');
            break;

        case 'this_week':
            $request->where('assigned_requests.created_at', '>=', Carbon::now()->subWeek())
                ->select(
                    DB::raw("DATE_FORMAT(assigned_requests.created_at, '%Y-%m-%d') as date"),
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                )
                ->groupBy(DB::raw("DATE_FORMAT(assigned_requests.created_at, '%Y-%m-%d')"))
                ->orderBy(DB::raw("DATE_FORMAT(assigned_requests.created_at, '%Y-%m-%d')"), 'ASC');
            break;

        case 'this_month':
            $request->select(
                DB::raw("YEAR(assigned_requests.created_at) as year"),
                DB::raw("WEEK(assigned_requests.created_at) as week"),
                DB::raw('COUNT(*) as total_assigned_requests'),
                DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
            )
                ->groupBy(DB::raw("YEAR(assigned_requests.created_at), WEEK(assigned_requests.created_at)"))
                ->orderBy(DB::raw("YEAR(assigned_requests.created_at), WEEK(assigned_requests.created_at)"), 'ASC');
            break;
    }

    return $request->whereBetween('assigned_requests.created_at', [$carbon->startOfMonth()->toDateTimeString(), $carbon->endOfMonth()->toDateTimeString()])->get();
};


?>

<div class="px-10 py-6">

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

    <div class="flex mt-2 justify-center flex-wrap">
        <!-- Technician Metrics -->
        <div>
            <div class="bg-white p-4 rounded-md shadow-md h-full">
                <h3 class="text-xl font-semibold mb-2">Staff Performance Overview</h3>
                <div class="space-y-3">
                    <div><strong>Rate:</strong> {{ $totalRatings }}</div>
                    <div><strong>Assigned Requests:</strong> {{ $totalAssignedRequests }}</div>
                    <div><strong>Requests Completed:</strong> {{ $totalRequestsCompleted }}</div>
                    <div><strong>Completion Rate:</strong> {{ $completionRate }}%</div>
                </div>
            </div>
        </div>

        <!-- Chart Display -->
        <div class="w-full max-w-3xl mx-auto h-fit" x-data="{
            data: {{ json_encode($this->techStaffMetrics()) }},
            chartData: { labels: [], assignedData: [], resolvedData: [] },
            init() {
                if (window.myChart) window.myChart.destroy();
                this.chartData.labels = this.data.map(item => item.date);
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
</div>