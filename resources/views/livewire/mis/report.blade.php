<?php

use App\Models\Request;
use App\Models\TechnicalStaff;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{mount, on, state};


state('techStaff');
state('techId');
state('date');
state('totalAssignedRequests');
state('totalRequestsCompleted');
state('completionRate');
state('totalRatings');

$total = function () {
    $this->totalAssignedRequests = Request::where('assigned_requests.technicalStaff_id', $this->techId)->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')->count();

    $this->totalRequestsCompleted = Request::where('assigned_requests.technicalStaff_id', $this->techId)->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')->where('requests.status', 'resolved')->count();

    $this->totalRatings = Request::where('assigned_requests.technicalStaff_id', $this->techId)
        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
        ->where('requests.status', 'resolved')
        ->avg('rate');

    $this->completionRate =  $this->totalAssignedRequests > 0
        ? round(($this->totalRequestsCompleted / $this->totalAssignedRequests) * 100, 2)
        : 0;
};



mount(function () {


    $this->date = $this->date ?? 'today'; //default date

    $this->techStaff = TechnicalStaff::with('user')->get();

    $this->techId = $this->techId ?? $this->techStaff->first()->user->id; //defualt id user

    $this->total();
});

on(['update' => function () {

    $this->total();
}]);

$techStaffMetrics = function () {
    $date = $this->date;
    $id = $this->techId;
    $carbon = Carbon::now();
    $request = [];
    switch ($date) {
        case 'today':
            $request = Request::where('assigned_requests.technicalStaff_id', $id)
                ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
                ->whereDate('assigned_requests.created_at', Carbon::today())
                ->select(
                    DB::raw("strftime('%Y-%m-%d %H', assigned_requests.created_at) as date"),
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                )
                ->groupBy(DB::raw("strftime('%Y-%m-%d %H', assigned_requests.created_at)"))
                ->orderBy(DB::raw("strftime('%Y-%m-%d %H', assigned_requests.created_at)"), 'ASC');
            break;

        case 'this_week':
            $request = Request::where('assigned_requests.technicalStaff_id', $id)
                ->where('assigned_requests.created_at', '>=', Carbon::now()->subWeek())
                ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
                ->select(
                    DB::raw("strftime('%Y-%m-%d', assigned_requests.created_at) as date"),
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')

                )
                ->groupBy(DB::raw("strftime('%Y-%m-%d', assigned_requests.created_at)"))
                ->orderBy(DB::raw("strftime('%Y-%m-%d', assigned_requests.created_at)"), 'ASC');
            break;

        case 'this_month':
            $request = Request::where('assigned_requests.technicalStaff_id', $id)
                ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')
                ->select(
                    DB::raw("strftime('%Y', assigned_requests.created_at) as week"),
                    DB::raw("strftime('%W', assigned_requests.created_at) as date"),
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')

                )
                ->groupBy(DB::raw("strftime('%Y', assigned_requests.created_at)"), DB::raw("strftime('%W', assigned_requests.created_at)"))
                ->orderBy(DB::raw("strftime('%Y', assigned_requests.created_at)"), 'ASC')
                ->orderBy(DB::raw("strftime('%W', assigned_requests.created_at)"), 'ASC');
            break;
    };

    return $request->whereBetween('assigned_requests.created_at', [
        $carbon->startOfMonth()->toDateTimeString(),
        $carbon->endOfMonth()->toDateTimeString()
    ])->get();
};



?>
<div class="">

    <div name="select">
        <!-- Date Selection -->
        <div class="mb-2">
            <label for="date" class="font-semibold text-lg">Select Date:</label>
            <select wire:model.change="date" name="date" id="date" class="input w-full" @change="$dispatch('update')">
                <option value="today">Today</option>
                <option value="this_week">This Week</option>
                <option value="this_month">This Month</option>
            </select>

        </div>

        <!-- Tech Staff Selection -->
        <div class="">
            <label for="techId" class="font-semibold text-lg">Select Technical Staff:</label>
            <select wire:model.change="techId" name="techId" id="techId" class="input w-full" @change="$dispatch('update')">
                @foreach ($techStaff as $staff)
                <option value="{{ $staff->user->id }}">{{ $staff->user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="flex mt-2  justify-center flex-wrap">

        <div>
            <!-- Technician Metrics -->
            <div class="bg-white p-4 rounded-md shadow-md">
                <h3 class="text-xl font-semibold mb-2">Staff Performance Overview</h3>
                <div class="space-y-3">
                    <div><strong>Rate:</strong> {{$totalRatings}}</div>
                    <div><strong>Assigned Requests:</strong> {{$totalAssignedRequests}}</div>
                    <div><strong>Requests Completed:</strong> {{$totalRequestsCompleted}}</div>
                    <div><strong>Completion Rate:</strong> {{$completionRate}}%</div>
                </div>
            </div>
        </div>



        <!-- Chart Display (Loading State Hidden) -->
        <div wire:loading.class="hidden" class="h-[500px] w-full max-w-3xl mx-auto"
            x-data="{ 
        data: {{ json_encode($this->techStaffMetrics()) }},
        chartData: {
            labels: [],
            assignedData: [],
            resolvedData: []
        },
        init() {
            if (window.myChart) {
                window.myChart.destroy(); 
            }
            this.chartData.labels = this.data.map(item => item.date);
            this.chartData.assignedData = this.data.map(item => item.total_assigned_requests);
            this.chartData.resolvedData = this.data.map(item => item.total_requests_resolved);
            this.createChart();
        },
        createChart() {
            window.myChart = new Chart(this.$refs.chartCanvas, {
                type: 'bar',  
                data: {
                    labels: this.chartData.labels,
                    datasets: [
                        {
                            label: 'Assigned Requests',
                            data: this.chartData.assignedData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: '#1D77FF',
                            fill: true,
                        },
                        {
                            label: 'Requests Resolved',
                            data: this.chartData.resolvedData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: '#FFCC00',
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 3000,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Requests'
                            },
                            min: 0,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
    }" x-init="init">
            <canvas x-ref="chartCanvas" class=" mt-2 rounded-mb border"></canvas>
        </div>



    </div>




</div>