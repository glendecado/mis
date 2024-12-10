<?php

use App\Events\RequestEvent;
use App\Models\AssignedRequest;
use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Notifications\NewRequest;

use function Livewire\Volt\{mount, on, placeholder, rules, state, title};

placeholder(<<<'HTML'
    <div class="rounded-md w-full h-full z-50 flex items-center justify-center">
        <x-loaders.b-square />
    </div>
HTML);

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

        if (session('user')['role'] == 'Faculty') {
            $this->college = session('user')['college'];
            $this->building = session('user')['building'];
            $this->room = session('user')['room'];
        }
    },
]);

on(['view-detailed-request' => function () {
    $this->viewDetailedRequest();
}]);

mount(function () {


    session(['page' => 'request']);

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



    if ($this->status == null && $this->id == null) {
        $this->redirect('/request?status=all', navigate: true);
    };

    if (!is_null($this->status)) {
        Cache::forget('status_' . session('user')['id']);
        $status = Cache::remember('status_' . session('user')['id'], 60 * 60 * 24, function () {
            return $this->status;
        });
    }
});



//viewDetailed Req
$viewDetailedRequest = function () {

    return Request::where('id', $this->id)->with('faculty')->get();
};

//view request with table
$viewRequest = function () {

    //selecting what status to show, if all then this will show
    if ($this->status == 'all') {
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
        ")->orderBy('created_at', 'desc')->with(['category', 'faculty'])->get();


                break;



            case 'Faculty':
                //all request of a current faculty
                $req =  Request::where('faculty_id', session('user')['id'])
                    ->with(['category', 'faculty'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                break;



            case 'Technical Staff':

                //get all assigned task from auth techstaff
                $task = AssignedRequest::where('technicalStaff_id', session('user')['id'])->get();

                //get all request id from it
                $techtask = $task->pluck('request_id')->toArray();


                //request by priority level
                $req = Request::whereIn('id', $techtask)->orderBy('priorityLevel', 'asc')->with(['category', 'faculty'])->get();



                break;
        }
    }
    //showing with status
    else {
        switch (session('user')['role']) {


            case 'Mis Staff':
                $req = Request::where('status', $this->status)->with('category')->get();

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
                $task = AssignedRequest::where('technicalStaff_id', session('user')['id'])->get();

                //get all request id from it
                $techtask = $task->pluck('request_id')->toArray();


                //request by priority level
                $req = Request::whereIn('id', $techtask)->orderBy('priorityLevel', 'asc')->orderBy('created_at', 'asc')->where('status', $this->status)->with('category')->get();

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


    //getting the id of mis first then dispatch the event to mis
    $mis = User::where('role', 'Mis Staff')->first();

    $mis->notify(new NewRequest($req));

    RequestEvent::dispatch($mis->id);



    $this->dispatch('success', 'Added Successfully, but reverb is not running');


};

//delete request
$deleteRequest = function ($id) {
    $req = Request::find($id);
    $req->delete();
};

//confirm location
$confirmLocation = function () {



    $user = Auth::user()->faculty;
    $user->college = strtoupper($this->college);
    $user->building = strtoupper($this->building);
    $user->room = strtoupper($this->room);
    $user->save();


    session([
        'user.college' => strtoupper($this->college),
        'user.building' => strtoupper($this->building),
        'user.room' =>  strtoupper($this->room),
    ]);

    $this->dispatch('success', 'Location Updated');
};



//update status 
$updateStatus = function ($status) {

    $this->dispatch('success', $status == 'pending' ? 'Request Accepted you can now update the priority level and assign tehcnical staff' : 'Request Declined');

    $req = Request::find($this->id);
    $req->status = $status;
    $req->save();
};

//update priority level of a request
$priorityLevelUpdate = function ($level) {

    $req = Request::find($this->id);
    $req->priorityLevel = $level;
    $req->save();


    $this->dispatch('success', 'successfuly changed');
};

$feedbackAndRate = function($rating,$feedback){
    $req = Request::find($this->id);
    $req->rate = $rating;
    $req->feedback = $feedback;
    $req->save();
    $this->dispatch('success', 'Rate and Feedback successfuly sent');
    $this->dispatch('close-modal', 'rateFeedback');
};

?>
<div class="overflow-auto">


    <x-alerts />

    @include('components.requests.view')

    <div
        x-init="Echo.private('request-channel.{{session('user')['id']}}')
            .listen('RequestEvent', (e) => {
                $wire.$refresh();
                console.log('connected');
            });
     ">

    </div>

    


</div>