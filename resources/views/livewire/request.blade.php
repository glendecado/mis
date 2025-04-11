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
    use Livewire\WithPagination;
use PhpParser\Node\Expr\Assign;

    use function Livewire\Volt\{title, mount, on, placeholder, rules, state, usesPagination,};

    title('Request');

    usesPagination(theme: 'tailwind');

    placeholder('<div class="rounded-md w-full h-full z-50 flex items-center justify-center"><x-loaders.b-square /></div>');



    state('search');

    state(['tab', 'status'])->url();

    //location
    state(['site', 'officeOrBuilding',]);

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
                $this->site = session('user')['site'];
                $this->officeOrBuilding = session('user')['officeOrBuilding'];
            }
        },
    ]);

    on(['view-detailed-request' => function () {
        $this->viewDetailedRequest();
    }]);

    on(['view-request' => function () {
        $this->viewRequest();
    }]);


    //sessions
    $sessionPage = fn() => session(['page' => 'request']);
    $sessionRequestId = fn() => session(['requestId' => $this->id ?? null]);
    $sessionFacultyLocation = function () {
        if (session('user')['role'] == 'Faculty') {
            $this->site = session('user')['site'];
            $this->officeOrBuilding = session('user')['officeOrBuilding'];
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
                    return $this->redirect('/request/' . $id, navigate: true);
                    break;
                case 2:
                    if ($lvl1 > 0) {
                        //You have unfinished high-priority requests!
                        $this->dispatch('danger', 'You have unfinished high-priority requests!');
                    } else {
                        return $this->redirect('/request/' . $id, navigate: true);
                    }
                    break;

                case 3:
                    //You have unfinished mid-priority requests!
                    if ($lvl1 > 0 || $lvl2 > 0) {
                        $this->dispatch('danger', 'You have unfinished mid-priority requests!');
                    } else {
                        return $this->redirect('/request/' . $id, navigate: true);
                    }
                    break;
            }
        } else {
            return $this->redirect('/request/' . $id, navigate: true);
        }
    };


    //view


    //viewDetailed Req
    $viewDetailedRequest = function () {

        $user = User::find(session('user')['id']); // Finds the user with

        $user->unreadNotifications // Accesses the unread notifications for the user
            ->where('data.req_id', $this->id) // Filters the unread notifications by the specific ID
            ->markAsRead(); // Marks the filtered notification as read



        $cache = Cache::flexible('request_' . $this->id, [5, 10], function () {
            return Request::where('id', $this->id)->with(['faculty', 'faculty.user'])->get();
        });
        return $cache;
    };

    //view request with table
    $viewRequest = function () {

        $query = Request::with(['categories', 'categories.category', 'faculty', 'faculty.user']);

        switch (session('user')['role']) {
            case 'Faculty':
                $query->where('faculty_id', session('user')['id']);
                break;
            case 'Technical Staff':
                $taskIds = AssignedRequest::where('technicalStaff_id', session('user')['id'])
                    ->pluck('request_id');
                $query->whereIn('id', $taskIds)->orderBy('priorityLevel');
                break;
                // Add other roles if needed
        }

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        } 

        // Add search functionality
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';

            $query->where(function ($q) use ($searchTerm) {
                $q->where('concerns', 'like', $searchTerm)
                    ->orWhere('status', 'like', $searchTerm)
                    ->orWhere('location', 'like', $searchTerm)
                    ->orWhere('progress', 'like', $searchTerm)
                    ->orWhereHas('categories', function ($q2) use ($searchTerm) {
                        $q2->whereHas('category', function ($q3) use ($searchTerm) {
                            $q3->where('name', 'like', $searchTerm);
                        });
                    })
                    ->orWhereHas('faculty.user', function ($q2) use ($searchTerm) {
                        $q2->where('name', 'like', $searchTerm);
                    });
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(7);
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



        $location = strtoupper($this->site) . ',  ' . strtoupper($this->officeOrBuilding) . ' ';

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
        $this->redirect('/', navigate: true);
    };

    //confirm location
    $confirmLocation = function () {


        session([
            'user.site' => strtoupper($this->site),
            'user.officeOrBuilding' => strtoupper($this->officeOrBuilding),
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

        $ass = AssignedRequest::where('request_id', $req->id)->pluck('technicalStaff_id')->toArray();

        foreach($ass as $f){
            RequestEvent::dispatch($f);
        }

        $faculty = User::where('id', $req->faculty_id)->first();

        $faculty->notify(new RequestStatus($req));
        $req->save();
        RequestEvent::dispatch($faculty->id);
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

        $this->redirect('/request/'.$this->id, navigate: true);
    };



    ?>
    <div>



        @php
        $pendingRatings = DB::table('requests')
        ->where('status', 'resolved')
        ->where('faculty_id', session('user')['id'])
        ->whereNull('rate')
        ->get();
        @endphp

        @if($pendingRatings->count())
        <div x-data="{ show: true, showModal: false }">
            <!-- Notification -->
            <div class="bg-amber-50 border-l-4 border-amber-400 rounded-r-lg p-4 mb-4 cursor-pointer hover:bg-amber-100 transition-colors duration-200 shadow-sm relative"
                x-show="show">
                <div class="flex items-center">
                    <button @click="show = false" class="absolute top-2 right-2 text-amber-600 hover:text-amber-800 transition-colors">
                        ✖
                    </button>

                    <div class="flex-shrink-0 text-amber-500 bg-amber-100/50 rounded-full p-2 animate-pulse">
                        ⚠️
                    </div>

                    <div class="ml-3">
                        <p class="text-sm text-amber-800 font-medium">
                            You have resolved requests that need rating!
                            <a href="#" @click.prevent="showModal = true"
                                class="font-semibold text-amber-600 hover:text-amber-800 underline underline-offset-2 transition-colors duration-200 ml-1">
                                Rate now →
                            </a>
                        </p>

                        <div class="mt-1 w-full bg-amber-100 rounded-full h-1">
                            <div class="bg-amber-400 h-1 rounded-full w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal with Pending Ratings -->
            <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div @click.outside="showModal = false"
                    class="bg-white rounded-xl p-6 max-w-2xl w-full shadow-xl transition-all transform"
                    x-transition>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Pending Ratings</h2>

                    <ul class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto mb-4">
                        @foreach($pendingRatings as $request)
                        <li class="py-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 w-60 truncate ">
                                        {{ $request->concerns }}
                                    </p>
                                    <p class="text-xs text-gray-500">Resolved at {{ \Carbon\Carbon::parse($request->updated_at)->format('M d, Y') }}</p>
                                </div>
                                <a href="/request/{{$request->id}}"
                                    class="text-amber-600 hover:text-amber-800 text-sm underline underline-offset-2">
                                    Rate →
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="text-right">
                        <button @click="showModal = false"
                            class="text-sm px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif







        @include('components.requests.view')






    </div>