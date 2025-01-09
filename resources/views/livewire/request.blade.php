<?php

use App\Events\RequestEvent;
use App\Models\AssignedRequest;
use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use App\Notifications\FeedbackRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Notifications\NewRequest;
use App\Notifications\RequestStatus;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;

use function Livewire\Volt\{title, mount, on, placeholder, rules, state,};

title('Request');

placeholder('<div class="rounded-md w-full h-full z-50 flex items-center justify-center"><x-loaders.b-square /></div>');






state(['tab', 'status'])->url();

//location
state(['college', 'building', 'room']);

//for requests
state(['id', 'concerns', 'priorityLevel', 'request']);

state('category')->modelable();

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



//sessions
$sessionPage = fn() => session(['page' => 'request']);
$sessionRequestId = fn() => session(['requestId' => $this->id ?? null]);
$sessionFacultyLocation = function () {
    if (session('user')['role'] == 'Faculty') {
        $this->college = session('user')['college'];
        $this->building = session('user')['building'];
        $this->room = session('user')['room'];
    }
};




//request in cache
$getCachedRequests = fn() => Cache::rememberForever('requests', function () {
    return Request::with(['category', 'faculty'])->get();
});

//reload
$reload = function () {

    Cache::forget('requests');
    $this->mount();
};

//what status did the users clicked?
$whatStatusIsClicked  = function () {
    if (!is_null($this->status)) {
        Cache::forget('status_' . session('user')['id']);
        $status = Cache::remember('status_' . session('user')['id'], 60 * 60 * 24, function () {
            return $this->status;
        });
    }
};

$redirectIfStatusIsNull = function () {
    if ($this->status == null && $this->id == null) {
        $this->redirect('/request?status=all', navigate: true);
    };
};

mount(function () {





    $this->sessionPage();

    $this->sessionRequestId();

    $this->sessionFacultyLocation();

    $this->redirectIfStatusIsNull();

    $this->whatStatusIsClicked();

    $this->getCachedRequests();
});



//view


//viewDetailed Req
$viewDetailedRequest = function () {

    $user = User::find(session('user')['id']); // Finds the user with

    $user->unreadNotifications // Accesses the unread notifications for the user
        ->where('data.req_id', $this->id) // Filters the unread notifications by the specific ID
        ->markAsRead(); // Marks the filtered notification as read

    return Request::where('id', $this->id)->with('faculty')->get();
};

//view request with table
$viewRequest = function () {

    $requests = Cache::get('requests');

    switch (session('user')['role']) {


        case 'Mis Staff':
            $req = $requests->sortBy(function ($item) {
                // Define sorting priority based on status
                return match ($item->status) {
                    'waiting' => 1,
                    'pending' => 2,
                    'ongoing' => 3,
                    'resolved' => 4,
                    default => 5,
                };
            })->sortByDesc('created_at');
            break;




        case 'Faculty':
            $req = $requests->filter(function ($request) {
                return $request->faculty_id == session('user')['id'];
            })->sortByDesc('created_at');
            break;



        case 'Technical Staff':
            //get all assigned task from auth techstaff
            $task = AssignedRequest::where('technicalStaff_id', session('user')['id'])->get();
            //get all request id from it
            $techtask = $task->pluck('request_id')->toArray();
            //request by priority level
            $req = $requests->whereIn('id', $techtask)->sortBy('priorityLevel');
            break;
    }

    if ($this->status !== 'all') {
        return $req = $req->where('status', $this->status);
    } else {
        return $req;
    }
};


//actions

//add request
$addRequest = function () {
    /*     $key = 'add-request:' . request()->ip();  // Rate limit based on IP address

    // Check if the user has exceeded the rate limit (e.g., 5 requests per minute)
    if (RateLimiter::tooManyAttempts($key, 5)) {
        // Provide feedback to the user
        $this->dispatch('danger', 'Too many requests. Please try again later.');
        return;
    }

    // Increment the attempts count with a 1hr expiration
    RateLimiter::hit($key, 60 * 60); */

    $this->validate();



    $category = Category::find($this->category);

    if (!$category) {
        $category = Category::firstOrCreate(
            ['name' => ucfirst($this->category)], 
            ['name' => $this->category] 
        );
    }



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
    $this->reload();
};

//delete request
$deleteRequest = function ($id) {
    $req = Request::find($id);
    $req->delete();
    $this->dispatch('success', 'deleted Successfully');
    $this->reload();
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
    $this->reload();
};



//update status 
$updateStatus = function ($status) {

    $this->dispatch('success', 
    $status == 'pending' 
        ? 'Request Accepted. You can now update the priority level and assign technical staff.' 
        : ($status == 'ongoing' 
            ? 'Accepted' 
            : 'Declined'
        )
);


    $req = Request::where('id', $this->id)->with('faculty')->first();
    $req->status = $status;


    $faculty = User::where('id', $req->faculty_id)->first();

    $faculty->notify(new RequestStatus($req));
    $req->save();
    $this->reload();
};

//update priority level of a request
$priorityLevelUpdate = function ($level) {

    $req = Request::find($this->id);
    $req->priorityLevel = $level;
    $req->save();


    $this->dispatch('success', 'successfuly changed');
    $this->reload();
};

$feedbackAndRate = function ($rating, $feedback) {
    $req = Request::where('id', $this->id)->with('assignedRequest')->first();
    //find all tehcnical staff
    $technicalStaffIds = $req->assignedRequest->pluck('technicalStaff_id')->all();
    // Find users with those IDs
    $users = User::whereIn('id', $technicalStaffIds)->get();

    $req->rate = $rating;
    $req->feedback = $feedback;
    Notification::send($users, new FeedbackRating($req));
    $req->save();


    $this->dispatch('success', 'Rate and Feedback successfuly sent');
    $this->dispatch('close-modal', 'rateFeedback');
    $this->reload();
};



?>
<div>




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