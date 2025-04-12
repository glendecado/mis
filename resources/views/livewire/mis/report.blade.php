<?php

use App\Models\AssignedRequest;
use App\Models\Category;
use App\Models\Request;
use App\Models\TaskPerRequest;
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
state('categories');
state('categoryCounts');
state('categoryForMonth');

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
        ->orderBy('requests.created_at', 'desc')
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


    $ctgry = Request::where('assigned_requests.technicalStaff_id', $this->techId)

        ->where('assigned_requests.created_at', '>=', Carbon::now()->subWeek())

        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')->with(['categories', 'categories.category'])->get();


    $ctgryMonth = Request::where('assigned_requests.technicalStaff_id', $this->techId)
        ->whereBetween('assigned_requests.created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])
        ->where('assigned_requests.created_at', '>=', Carbon::now()->subWeek())

        ->join('assigned_requests', 'assigned_requests.request_id', '=', 'requests.id')->with(['categories', 'categories.category'])->get();

    $categoryIds = collect($ctgry)
        ->pluck('categories')
        ->collapse()
        ->pluck('category_id')
        ->filter() // Remove nulls (optional)
        ->unique()
        ->values();

    $categories = Category::whereIn('id', $categoryIds)
        ->pluck('name', 'id') // [id => name] mapping
        ->toArray();

    // Count categories, replacing null/empty with "Others" and IDs with names
    $this->categoryCounts = collect($ctgry)
        ->pluck('categories')
        ->collapse()
        ->pluck('category_id')
        ->map(function ($id) use ($categories) {
            // Treat empty string as null
            if ($id === "" || $id === null) {
                return 'Others';
            }
            // Return category name if exists, otherwise 'Unknown'
            return $categories[$id] ?? 'Unknown';
        })
        ->countBy()
        ->all();

    $cMonth = collect($ctgryMonth)
        ->pluck('categories')
        ->collapse()
        ->pluck('category_id')
        ->map(function ($id) use ($categories) {
            // Treat empty string as null
            if ($id === "" || $id === null) {
                return 'Others';
            }
            // Return category name if exists, otherwise 'Unknown'
            return $categories[$id] ?? 'Unknown';
        })
        ->countBy()
        ->all();

    $this->categoryForMonth = $cMonth;

    $this->categories = $this->categoryCounts;
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


$requests = function () {
    $taskIds = AssignedRequest::where('technicalStaff_id', $this->techId)
        ->pluck('request_id');

    $requests = Request::whereIn('id', $taskIds)->where('status', 'resolved')->with('categories')->get();

    return $requests;
};

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


    return $request->whereBetween('assigned_requests.created_at', [$carbon->startOfMonth()->toDateTimeString(), $carbon->endOfMonth()->toDateTimeString()])->get();
};
?>

<div class="px-0 md:px-4 py-4 bg-slate-100 rounded-md">


    <div wire:loading wire:target="addUser" class="w-full h-dvh">
        <div class="fixed inset-0 w-full h-svh bg-black/50 z-[100] flex items-center justify-center">
            <x-loaders.b-square />
        </div>
    </div>



    <div name="select" class="flex w-full gap-2">
        <!-- Date Selection -->

        <!-- Tech Staff Selection -->
        <div class="px-4">
            <label for="techId" class="block font-semibold text-gray-700 mb-1">Select Technical Staff:</label>
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






    <div class="px-4 py-4">
        @if(!$this->techStaff->isEmpty())

        @include('components.reports.summary')






        <div class="mt-4">
            @include('components.reports.cat')

        </div>


        @include('components.reports.detailed')

        @include('components.reports.feedback')


        @else
        <div class="col-span-full text-center py-8 text-gray-500">
            No technical staff metrics data available
        </div>
        @endif





    </div>