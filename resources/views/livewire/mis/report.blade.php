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
state('feedback');

placeholder('<div class="rounded-md w-full h-full z-50 flex items-center justify-center"><x-loaders.b-square /></div>');

$total = function () {
    if (!$this->techId) {
        $this->totalAssignedRequests = 0;
        $this->totalRequestsCompleted = 0;
        $this->totalRatings = 0;
        $this->completionRate = 0;
        return;
    }

    $this->feedback = Request::join('assigned_requests', 'requests.id', '=', 'assigned_requests.request_id')
        ->where('assigned_requests.technicalStaff_id', $this->techId)
        ->whereNotNull('feedback')
        ->select(['feedback'])
        ->get();

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

        @include('components.reports.summary')

        @include('components.reports.detailed')

        @include('components.reports.feedback')


</div>