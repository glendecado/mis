<?php

use App\Models\Category;
use App\Models\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

use function Livewire\Volt\{mount, on, rules, state, title};

title('Request');

state(['cacheKey']);

state(['tab', 'status'])->url();

//location
state(['college', 'building', 'room']);

//for requests
state(['id', 'category', 'concerns', 'priorityLevel', 'request']);

rules([
    'concerns' => 'required|min:10',
]);

on([
    'resetErrors' => function () {
        $this->resetErrorBag();
    },
]);

on(['view-detailed-request' => function () {
    $this->viewDetailedRequest();
    $this->forgetCache();
}]);

mount(function () {
    $this->cacheKey = 'requests_';

    //initial valye of category
    $this->category = '1';

    //initial value of location
    if (session('user')['role'] == 'Faculty') {
        $this->college = session('user')['college'];
        $this->building = session('user')['building'];
        $this->room = session('user')['room'];
    }

    session(['requestId' => $this->id ?? null]);
});

//to forget the cache
$forgetCache = function () {

    Cache::forget($this->cacheKey);
    Cache::forget($this->cacheKey . 'faculty_' . session('user')['id']);
    Cache::forget($this->cacheKey . 'technicalStaff_' . session('user')['id']);
    Cache::forget($this->cacheKey . $this->id);
    Cache::forget($this->cacheKey . 'waiting');
    Cache::forget($this->cacheKey . 'pending');
    Cache::forget($this->cacheKey . 'ongoing');
    Cache::forget($this->cacheKey . 'resolved');
};

//viewDetailed Req
$viewDetailedRequest = function () {

    return Request::where('id', $this->id)->with('faculty')->get();
};

//view request with table
$viewRequest = function () {

  if($this->status == 'all'){
    switch (session('user')['role']) {


        case 'Mis Staff':
            $req = Request::with('category')->get();

            break;



        case 'Faculty':
            //all request of a current faculty
            $req =  Request::where('faculty_id', session('user')['id'])
                    ->with('category')
                    ->get();
  
            break;



        case 'Technical Staff':
            $req = Task::where('technicalStaff_id', session('user')['id'])
                    ->with('request')
                    ->get()
                    ->pluck('request');
  
            break;
    }
  } else {
    switch (session('user')['role']) {


        case 'Mis Staff':
            $req = Request::with('category')->where('status', $this->status)->get();

            break;



        case 'Faculty':
            //all request of a current faculty
            $req =  Request::where('faculty_id', session('user')['id'])
                    ->with('category')
                    ->where('status', $this->status)
                    ->get();
  
            break;



        case 'Technical Staff':
            $req = Task::where('technicalStaff_id', session('user')['id'])
            ->whereHas('request', function ($query) {
                $query->where('status', $this->status);
            })
            ->with('request')
            ->get()
            ->pluck('request');
            break;
    }
  }
        
    

    return $req;
};



//add request
$addRequest = function () {
    $this->validate();
    $category = Category::firstOrCreate(
        ['id' => $this->category], // Attributes to find
        ['name' => $this->category], // Attributes to create if not found
    );
    $req = Request::create([
        'faculty_id' => session('user')['id'],
        'category_id' => $category->id,
        'concerns' => $this->concerns,
    ]);

    $req->save();
    $this->dispatch('success', 'Added Successfully');
    $this->dispatch('close-modal', 'add-request-modal');
    $this->forgetCache();
};

//delete request
$deleteRequest = function ($id) {
    $req = Request::find($id);
    $req->delete();
};

//confirm location
$confirmLocation = function () {
    $user = Auth::user()->faculty;
    $user->college = $this->college;
    $user->building = $this->building;
    $user->room = $this->room;
    $user->save();

    session([
        'user.college' => $this->college,
        'user.building' => $this->building,
        'user.room' => $this->room,
    ]);

    $this->dispatch('success', 'Loction Successfully saved');
};



//update status 
$updateStatus = function ($status) {
    $req = Request::find($this->id);
    $req->status = $status;
    $req->save();
    $this->forgetCache();
};

//update priority level of a request
$priorityLevelUpdate = function ($level) {

    $req = Request::find($this->id);
    $req->priorityLevel = $level;
    $req->save();
    $this->forgetCache();

    $this->dispatch('success', 'successfuly changed');
};

?>
<div class="h-[85vh] w-full flex justify-center overflow-auto">


    @include('components.requests.view')

    <x-alerts />


</div>