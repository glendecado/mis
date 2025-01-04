    <?php

    use App\Models\AssignedRequest;
    use App\Models\Request;
    use App\Models\TechnicalStaff;
    use App\Models\User;
    use Illuminate\Support\Facades\Cache;

    use function Livewire\Volt\{mount, state, title};

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

        switch ($date) {
            case 'today':
                // Start of the day should be at 00:00:00 (midnight)
                $startDate = $now->copy()->startOfDay(); // Ensures the time is 00:00:00
                // End of the day should be at 23:59:59 (end of the day)
                $endDate = $now->copy()->endOfDay(); // Ensures the time is 23:59:59
                break;
        
            case 'this_week':
                // Start of the week (Sunday by default) at 00:00:00
                $startDate = $now->copy()->startOfWeek(); 
                // End of the week (Saturday) at 23:59:59
                $endDate = $now->copy()->endOfWeek();
                break;
        
            case 'this_month':
                // Start of the month at 00:00:00
                $startDate = $now->copy()->startOfMonth(); 
                // End of the month at 23:59:59
                $endDate = $now->copy()->endOfMonth(); 
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
            ? ($totalRequestsCompleted / $totalAssignedRequests) * 100
            : 0;

        // Total Ratings
        $totalRatings = Request::whereHas('assignedRequest', function ($query) use ($technicalStaffId) {
            $query->where('technicalStaff_id', $technicalStaffId);
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('rate');



        // Return all metrics
        return [
            'totalAssignedRequests' => $totalAssignedRequests,
            'totalRequestsCompleted' => $totalRequestsCompleted,
            'completionRate' => $completionRate,
            'totalRatings' => $totalRatings,
        ];
    };


    ?>
    <div>


        <div class="md:m-16 rounded-md m-0 border">
            <div class="border-b p-7 flex justify-between">
                <h1 class="font-bold ">Technical Staff Accomplishment Reports</h1>
                <input type="text" class="input w-[20%] flex-none">
            </div>
            <div class="p-10">

                <select wire:model.live="techId" name="technicalStaff" id="technicalStaff" class="input h-10">
                    <option value="">TECH STAFF NAME</option>
                    @foreach ($this->technicalStaff as $staff)
                    <option value="{{ $staff->technicalStaff_id }}">{{ $staff->User->name ?? 'Unknown' }}</option>
                    @endforeach
                </select>


                <select wire:model.live="date" name="date" id="date" class="input h-10">
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                </select>

                <div class="mt-3">
                    <h1 class="font-bold">Summary Reports</h1>

                    <div class="ml-2">
                        <p>Total Service Request Completed:</p>
                        <p>Average Resolution Time:</p>
                        <p>Completion Rate:</p>
                    </div>

                </div>
            </div>
        </div>





        <div class="md:mx-16 rounded-md m-0 border">


            <div class="border-b p-7">
                <h1 class="font-bold ">Staff Performance Overview</h1>
            </div>

            <div class="p-10" wire:loading.class="hidden">
                @if ($techId)
                @php
                $metrics = $this->getTechnicalStaffMetrics($techId, $date);
                @endphp
                <p>Total Assigned Requests: {{ $metrics['totalAssignedRequests'] }}</p>
                <p>Total Requests Completed: {{ $metrics['totalRequestsCompleted'] }}</p>
                <p>Completion Rate: {{ $metrics['completionRate'] }}%</p>
                <p>Total Ratings: {{ $metrics['totalRatings'] }}</p>
                @endif
            </div>


        </div>
    </div>