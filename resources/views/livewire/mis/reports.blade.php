<?php

use App\Models\AssignedRequest;
use App\Models\Request;
use App\Models\TechnicalStaff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{mount, on, state, title};

title('Reports');
state('requests');
state('technicalStaff');
state('techId');
state('date');


mount(function () {

    $this->date = 'today';

    $this->requests = Cache::remember('req', 60 * 60, function () {
        return Request::with(['assignedRequest'])->get();
    });

    $this->technicalStaff = Cache::remember('technical_staff', 60 * 60, function () {
        return TechnicalStaff::all();
    });
});




$request = function () {

    return $this->requests;
};

$getTechnicalStaffMetrics = function ($technicalStaffId, $date = 'today') {
    // Determine the date range based on the input date value
    $startDate = null;
    $endDate = null;
    $now = \Carbon\Carbon::now(); // Use Carbon for date manipulation
    $totalReq = [];

    switch ($date) {
        case 'today':
            // Start of the day should be at 00:00:00 (midnight)
            $startDate = $now->copy()->startOfDay(); // Ensures the time is 00:00:00
            // End of the day should be at 23:59:59 (end of the day)
            $endDate = $now->copy()->endOfDay(); // Ensures the time is 23:59:59

            $totalReq = AssignedRequest::where('technicalStaff_id', $technicalStaffId)
                ->whereDate('assigned_requests.created_at', Carbon::today()) // Filter for today
                ->join('requests', 'assigned_requests.request_id', '=', 'requests.id') // Join the requests table
                ->groupBy(DB::raw('strftime("%Y-%m-%d %H", assigned_requests.created_at)')) // Group by year-month-day-hour
                ->orderBy(DB::raw('strftime("%Y-%m-%d %H", assigned_requests.created_at)'), 'ASC')
                ->get([
                    DB::raw('strftime("%H:%M ", assigned_requests.created_at) as date'), // Format as Year-Month-Day-Hour
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                ]);


            break;

        case 'this_week':
            // Start of the week (Sunday by default) at 00:00:00
            $startDate = $now->copy()->startOfWeek();
            // End of the week (Saturday) at 23:59:59
            $endDate = $now->copy()->endOfWeek();
            $totalReq = Request::where('assigned_requests.technicalStaff_id', $technicalStaffId)
                ->where('assigned_requests.created_at', '>=', Carbon::now()->subWeek())
                ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id') // Join the assigned_requests table
                ->groupBy(DB::raw('DATE(assigned_requests.created_at)'))
                ->orderBy(DB::raw('DATE(assigned_requests.created_at)'), 'ASC')
                ->get([
                    DB::raw('DATE(assigned_requests.created_at) as date'),
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                ]);



            break;

        case 'this_month':
            // Start of the month at 00:00:00
            $startDate = $now->copy()->startOfMonth();
            // End of the month at 23:59:59
            $endDate = $now->copy()->endOfMonth();

            $currentYear = Carbon::now()->year;
            $currentWeek = Carbon::now()->weekOfYear;

            $totalReq = AssignedRequest::where('technicalStaff_id', $technicalStaffId)
                ->whereYear('assigned_requests.created_at', $currentYear) // Filter by the current year
                ->whereMonth('assigned_requests.created_at', $currentWeek) // Filter by the current week
                ->join('requests', 'assigned_requests.request_id', '=', 'requests.id') // Join the requests table
                ->groupBy(DB::raw('strftime("%Y-%m", assigned_requests.created_at)')) // Group by year and month
                ->orderBy(DB::raw('strftime("%Y-%m", assigned_requests.created_at)'), 'ASC')
                ->get([

                    DB::raw('strftime("%m-%Y", assigned_requests.created_at) as date'), // Format as Month-Year
                    DB::raw('COUNT(*) as total_assigned_requests'),
                    DB::raw('SUM(CASE WHEN requests.status = "resolved" THEN 1 ELSE 0 END) as total_requests_resolved')
                ]);





            break;

        default:
            // Default to today if no valid date range is passed
            $startDate = $now->copy()->startOfDay();
            $endDate = $now->copy()->endOfDay();
    }

    /*         \Log::info("Start Date: " . $startDate->toDateTimeString());
    \Log::info("End Date: " . $endDate->toDateTimeString()); */
    // Total Assigned Requests
    $totalAssignedRequests = AssignedRequest::where('technicalStaff_id', $technicalStaffId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Total Completed Requests
    $totalRequestsCompleted = AssignedRequest::where('technicalStaff_id', $technicalStaffId)
        ->whereHas('request', function ($query) {
            $query->where('status', 'resolved');
        })
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Completion Rate
    $completionRate = $totalAssignedRequests > 0
        ? round(($totalRequestsCompleted / $totalAssignedRequests) * 100, 2)
        : 0;

    // Total Ratings
    $totalRatings = AssignedRequest::where('assigned_requests.technicalStaff_id', $technicalStaffId)
        ->whereBetween('assigned_requests.created_at', [$startDate, $endDate]) // Filter by date range
        ->join('requests', 'assigned_requests.request_id', '=', 'requests.id') // Join the requests table
        ->whereNotNull('requests.rate') // Ensure that rating is not null (optional)
        ->avg('requests.rate'); // Count the non-null ratings




    // Return all metrics
    return [
        'totalAssignedRequests' => $totalAssignedRequests,
        'totalRequestsCompleted' => $totalRequestsCompleted,
        'completionRate' => $completionRate,
        'totalRatings' => $totalRatings,
        'date' => $totalReq
    ];
};



$metrics = fn() => $this->getTechnicalStaffMetrics($this->techId, $this->date);


?>
<div class="flex  flex-wrap w-full h-full">


    <div class="md:m-16 rounded-md m-0 border w-full md:w-[500px]">
        <div class="border-b p-7 flex justify-between ">
            <h1 class="font-bold ">Technical Staff Accomplishment Reports</h1>
        </div>
        <div class="p-2 w-full">

            <select wire:model.change="techId" name="technicalStaff" id="technicalStaff" class="input h-10 mb-4 mt-4">
                <option value="">TECH STAFF NAME</option>
                @foreach ($this->technicalStaff as $staff)
                <option value="{{ $staff->technicalStaff_id }}">{{ $staff->User->name ?? 'Unknown' }}</option>
                @endforeach
            </select>


            <select wire:model.change="date" name="date" id="date" class="input h-10">
                <option value="today">Today</option>
                <option value="this_week">This Week</option>
                <option value="this_month">This Month</option>
            </select>

            <div class="mt-2">
                <h1 class="font-bold">Summary Reports</h1>


                <p>Total Assigned Requests: {{ $this->metrics()['totalAssignedRequests'] }}</p>
                <p>Total Requests Completed: {{ $this->metrics()['totalRequestsCompleted'] }}</p>
                <p>Completion Rate: {{ $this->metrics()['completionRate'] }}%</p>
                <p>Total Ratings: {{ $this->metrics()['totalRatings'] ?? 0 }}</p>

            </div>
        </div>
    </div>


    <div class="flex-auto">



        <div class="border-b p-7">
            <h1 class="font-bold ">Staff Performance Overview</h1>
        </div>

        <div class="p-10">
            @if ($techId && $date)
            <div x-data="{ 
    data: {{ json_encode($this->metrics()) }},
    chartData: {
        labels: [],
        data: []
    },
    init() {
        if (window.myChart) {
            window.myChart.destroy(); // Destroy the old chart if it exists
        }

        // Prepare the chart data
        this.chartData.labels = this.data.date.map(week => week.date);
        this.chartData.data = this.data.date.map(week => week.total_assigned_requests);
        this.chartData.resolvedData = this.data.date.map(week => week.total_requests_resolved);
        
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
                        data: this.chartData.data,
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
                    duration: 3000, // Duration of the animation in milliseconds
                    easing: 'easeOutQuart' // Easing function for smooth animation
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
                            text: 'Assigned Request'
                        },
                        min: 0,
                        ticks : { stepSize: 1 }
                    }
                }
            }
        });
    }
}" x-init="init">
    <!-- Canvas for the Chart -->
    <canvas x-ref="chartCanvas"></canvas>
</div>

            @endif
        </div>


    </div>


</div>