<?php

use App\Events\RequestEvent;
use App\Models\AssignedRequest;
use App\Models\Request;
use App\Models\TechnicalStaff;
use App\Models\User;
use App\Notifications\AssingedRequest;
use Illuminate\Support\Facades\Cache;


use function Livewire\Volt\{computed, mount, on, state};

//
state(['id', 'AssignedRequest']);

on(['techs' => function () {

    $this->AssignedRequest = AssignedRequest::where('request_id', $this->id)->get();
}]);

mount(function () {


    $this->id = session('requestId');

    $cacheKey = "assigned_request_{$this->id}";

    if (Cache::has($cacheKey)) {
        Cache::forget($cacheKey);
    }

    // Cache the query result for 10 minutes
    $this->AssignedRequest = Cache::rememberForever($cacheKey, function () {
        return AssignedRequest::where('request_id', $this->id)->get();
    });
});


$viewTechStaff = computed(function ($arr = null) {
    if (is_null($arr)) {
        return Cache::flexible('tech', [5, 10], function () {
            return TechnicalStaff::with(['user', 'AssignedRequest'])
                ->whereHas('user', function ($query) {
                    $query->where('status', 'active');
                })
                ->get();
        });
    } else {
        return TechnicalStaff::whereIn('technicalStaff_id', $arr)->with(['user', 'AssignedRequest'])->get();
    }
});

$assignTask = function ($techId) {

    $notifUser = User::find($techId);
    $request = Request::where('id', session('requestId'))->first();

    $AssignedRequest = AssignedRequest::create([
        'technicalStaff_id' => $techId,
        'request_id' => session('requestId')
    ]);
    $AssignedRequest->save();
    $this->dispatch('techs');
    $this->dispatch('success', 'Assigned');
    RequestEvent::dispatch($techId);
    Cache::forget('requests');

    $notifUser->notify(new AssingedRequest($request));
};

$removeTask = function ($techId) {
    $notifUser = User::find($techId);
    $AssignedRequest = AssignedRequest::where('technicalStaff_id', $techId)->where('request_id', $this->id)->with("TechnicalStaff")->first();
    $this->dispatch('techs');
    $AssignedRequest->delete();
    $n = $notifUser->notifications()->where('data->req_id', intval($this->id))->delete();
    RequestEvent::dispatch($techId);
};


$viewAssigned = function () {

    $tech = $this->AssignedRequest->pluck('technicalStaff_id')->toArray();
    return $tech;
};
?>

<div>

    @include('components.assigned-request.view-assigned-request')

</div>