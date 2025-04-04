<?php

use App\Events\RequestEvent;
use App\Models\AssignedRequest;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Request;
use App\Models\User;
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


state(['category_' => []]);

rules([
    'concerns' => 'required|min:10',
    'category_' => 'required',
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
$getCachedRequests = fn() => Cache::flexible('requests', [5, 10], function () {
    return Request::with(['categories', 'categories.category', 'faculty', 'faculty.user'])->get();
});

//reload
$reload = function () {

    Cache::forget('requests');
    $this->mount();
};

//what status did the users clicked?
$whatStatusIsClicked  = function () {
    if (!is_null($this->status)) {
        session(['status' => $this->status]);
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


$checkPriorityLevel = function ($id) {

    $requestPrioLvl = Request::where('id', $id)->pluck('priorityLevel')->toArray();
    $lvl1 =  Request::where('priorityLevel', '1')->where('status', '!=', 'resolved')->get()->count();
    $lvl2 = Request::where('priorityLevel', '2')->where('status', '!=', 'resolved')->get()->count();


    if (session('user')['role'] == 'Technical Staff') {


        $num = $requestPrioLvl[0];

        switch ($num) {
            case 1:
                return $this->redirect('/request/' . $id);
                break;
            case 2:
                if ($lvl1 > 0) {
                    //You have unfinished high-priority requests!
                    $this->dispatch('danger', 'You have unfinished high-priority requests!');
                } else {
                    return $this->redirect('/request/' . $id);
                }
                break;

            case 3:
                //You have unfinished mid-priority requests!
                if ($lvl1 > 0 || $lvl2 > 0) {
                    $this->dispatch('danger', 'You have unfinished mid-priority requests!');
                } else {
                    return $this->redirect('/request/' . $id);
                }
                break;
        }
    } else {
        return $this->redirect('/request/' . $id);
    }
};


//view


//viewDetailed Req
$viewDetailedRequest = function () {

    $user = User::find(session('user')['id']); // Finds the user with

    $user->unreadNotifications // Accesses the unread notifications for the user
        ->where('data.req_id', $this->id) // Filters the unread notifications by the specific ID
        ->markAsRead(); // Marks the filtered notification as read



    $cache = Cache::rememberForever('request_' . $this->id, function () {
        return Request::where('id', $this->id)->with(['faculty', 'faculty.user'])->get();
    });

    return $cache;
};

//view request with table
$viewRequest = function () {

    $requests = Cache::get('requests') ?? Request::with(['categories', 'categories.category', 'faculty', 'faculty.user'])->get();

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
            if ($requests) {
                $req = $requests->whereIn('id', $techtask)->sortBy('priorityLevel');
            }

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



    $location = strtoupper($this->college) . ' ' . strtoupper($this->building) . ' ' . strtoupper($this->room);

    $req = Request::create([
        'faculty_id' => session('user')['id'],
        'concerns' => $this->concerns,
        'location' => $location,
    ]);



    foreach ($this->category_ as $categoryName) {
        if (is_numeric($categoryName)) {
            Categories::create([
                'request_id' => $req->id,
                'category_id' => $categoryName
            ]);
        } elseif (is_string($categoryName)) {
            // Create a temporary category entry
            $categories = Categories::create([
                'request_id' => $req->id,
                'ifOthers' => $categoryName
            ]);

            // Check if a category with the same name exists
            $existingCategory = Category::where('name', ucfirst($categoryName))->first();

            if ($existingCategory) {
                // Create a new entry using the found category's ID
                Categories::create([
                    'request_id' => $req->id,
                    'category_id' => $existingCategory->id
                ]);

                // Delete the temporary category entry
                $categories->delete();
            }
        }
    }


    $req->save();

    $this->dispatch('success', 'Added Successfully');
    $this->dispatch('close-modal', 'add-request-modal');
    $this->dispatch('reset-category');


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


    session([
        'user.college' => strtoupper($this->college),
        'user.building' => strtoupper($this->building),
        'user.room' =>  strtoupper($this->room),
    ]);

    $this->dispatch('success', 'Location Updated');
};



//update status 
$updateStatus = function ($status) {

    $this->dispatch(
        'success',
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
    RequestEvent::dispatch(1); //mis
    Cache::forget('request_' . $this->id);
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

    $req->rate = $rating;
    $req->feedback = $feedback;

    $req->save();

    Cache::forget('request_' . $this->id);
    $this->dispatch('success', 'Rate and Feedback successfuly sent');
    $this->dispatch('close-modal', 'rateFeedback');
    $this->reload();
};



?>
<div wire:poll>



    @if(DB::table('requests')
    ->where('status', 'resolved')
    ->where('faculty_id', session('user')['id'])
    ->whereNull('rate')
    ->count())
    <div class="bg-amber-50 border-l-4 border-amber-400 rounded-r-lg p-4 mb-4 cursor-pointer hover:bg-amber-100 transition-colors duration-200 shadow-sm relative"
        x-data="{ show: true }"
        x-show="show">
        <div class="flex items-center">
            <button @click="show = false" class="absolute top-2 right-2 text-amber-600 hover:text-amber-800 transition-colors">
                ✖
            </button>

            <div class="flex-shrink-0 text-amber-500 bg-amber-100/50 rounded-full p-2 animate-pulse group-hover:animate-none group-hover:scale-110 transition-transform duration-300">
                ⚠️
            </div>

            <div class="ml-3">
                <!-- Improved text hierarchy with subtle hover effect -->
                <p class="text-sm text-amber-800 font-medium">
                    You have resolved requests that need rating!
                    <a href="/request?status=resolved" class="font-semibold text-amber-600 hover:text-amber-800 underline underline-offset-2 transition-colors duration-200 ml-1">
                        Rate now →
                    </a>
                </p>

                <!-- Optional: Subtle progress indicator -->
                <div class="mt-1 w-full bg-amber-100 rounded-full h-1">
                    <div class="bg-amber-400 h-1 rounded-full w-3/4"></div>
                </div>
            </div>
        </div>
    </div>

    @endif

    @include('components.requests.view')

    @script
    <script>
        let userId = {{session('user')['id']}};
        Echo.private(`request-channel.${userId}`)
            .listen('RequestEvent', (e) => {
                $wire.$refresh();
                console.log('connected');
                console.log('disconnected');
            });

            Echo.leaveChannel(`request-channel.${userId}`);
    </script>

    @endscript




</div>