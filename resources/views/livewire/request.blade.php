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
            $req = Request::orderByRaw("
            CASE status
                WHEN 'waiting' THEN 1
                WHEN 'pending' THEN 2
                WHEN 'ongoing' THEN 3
                WHEN 'resolved' THEN 4
                ELSE 5
            END
        ")->orderBy('created_at', 'desc')->get();
        

            break;



        case 'Faculty':
            //all request of a current faculty
            $req =  Request::where('faculty_id', session('user')['id'])
                    ->with('category')
                    ->orderBy('created_at', 'desc')
                    ->get();
  
            break;



        case 'Technical Staff':

            //get all assigned task from auth techstaff
            $task = Task::where('technicalStaff_id', session('user')['id'])->get();

            //get all request id from it
            $techtask = $task->pluck('request_id')->toArray();
        

            //request by priority level
            $req = Request::whereIn('id', $techtask)->orderBy('priorityLevel', 'asc')->get();
            
 

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
            //get all assigned task from auth techstaff
            $task = Task::where('technicalStaff_id', session('user')['id'])->get();

            //get all request id from it
            $techtask = $task->pluck('request_id')->toArray();
        

            //request by priority level
            $req = Request::whereIn('id', $techtask)->orderBy('priorityLevel', 'asc')->where('status', $this->status)->get();
            
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
<div class="px-0 sm:px-0 md:px-0 lg:px-[20%] overflow-auto">


    @include('components.requests.view')

    <x-alerts />


</div>