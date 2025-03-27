<div class="w-full bg-blue-50 rounded-md p-4 shadow-md">
    @foreach($this->viewDetailedRequest() as $req)

    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-2">
        <!-- LEFT COLUMN: Faculty Info + Concerns -->
        <div class="bg-white p-4 rounded-md shadow">
            <div class="flex flex-row items-center justify-between mb-2">
                <div class="flex items-center justify-center gap-4">
                    <img src="{{asset('storage/'.$req->faculty->user->img)}}" alt="" class="size-16 rounded-full">
                    <div>
                        <span class="text-lg font-bold block">{{$req->faculty->user->name}}</span>
                        <span class="text-sm">
                            Date: <span class="font-bold">{{$req->created_at->format('m-d-y')}}</span>
                            Time: <span class="font-bold">{{$req->created_at->format('h:i A')}}</span>
                        </span>
                    </div>
                </div>

                <div class="p-3 text-white text-sm rounded-md leading-none flex bg-[#3D8D7A]">
                    <span class="font-bold">{{ $req->status }}</span>
                </div>

            </div>

            @if(($req->status == 'pending')
            && session('user')['role'] != 'Faculty'
            && session('user')['role'] != 'Technical Staff')
            <!-- Priority -->
            <span class="text-sm text-blue">You can now assign a priority level.</span>
            @endif

            @if(DB::table('requests')->where('id', session()->get('requestId'))->first()->status == 'pending' )
            @switch(session('user')['role'])
            @case('Mis Staff')
            <div class="mt-2">
                @if($req->status == 'ongoing' || $req->status == 'resolved')
<<<<<<< HEAD
                Priority Level:
=======
                Priority level:

>>>>>>> upstream/main
                <span class="font-bold px-2 py-1 rounded-md"
                    style="background-color: 
                                {{ $req->priorityLevel == 1 ? '#ef4444' : 
                                ($req->priorityLevel == 2 ? '#facc15' : '#22c55e') }};
                                color: {{ $req->priorityLevel == 2 ? 'black' : 'white' }};
                                padding: 6px 12px;
                                border-radius: 6px;
                                font-size: 14px;">
                    {{ $req->priorityLevel == 3 ? 'Low' : ($req->priorityLevel == 2 ? 'Medium' : 'High') }}
                </span>
                @elseif($req->status == 'pending')
                <div class="mb-2">
                    <label for="prio">Priority Level</label>
                    <select id="prio"
                        class="w-full p-2 border rounded-md transition-all duration-100 ease-in-out
                        text-white 
                        bg-red-400 dark:bg-red-500 
                        focus:outline-none "
                        wire:change="priorityLevelUpdate($event.target.value)"
                        :class="{
                        'bg-red-400 dark:bg-red-500': {{ $req->priorityLevel }} == 1,
                        'bg-yellow dark:bg-yellow text-black': {{ $req->priorityLevel }} == 2,
                        'bg-green-400 dark:bg-green-500': {{ $req->priorityLevel }} == 3
                    }">
                        <option value="1" @if($req->priorityLevel == 1) selected @endif
                            class="bg-red-400 text-white hover:bg-red-500">
                            High
                        </option>
                        <option value="2" @if($req->priorityLevel == 2) selected @endif
                            class="bg-yellow text-black hover:bg-yellow-500">
                            Medium
                        </option>
                        <option value="3" @if($req->priorityLevel == 3) selected @endif
                            class="bg-green-400 text-white hover:bg-green-500">
                            Low
                        </option>
                    </select>



                </div>
                @endif
            </div>
            @break
            @endswitch
            @else
            Priority Level
<<<<<<< HEAD
            <div class="priority-label mb-1"
=======
            <div class="priority-label"
>>>>>>> d7e3792ce14fdf8000a4bbd97f9802b2bf6ec139
                style="background-color:
                                {{ $req->priorityLevel == 1 ? '#EE4E4E' : 
                                ($req->priorityLevel == 2 ? '#FFC145' : '#77B254') }};
                                color: {{ $req->priorityLevel == 2 ? 'black' : 'white' }};
                                padding: 6px;
                                border-radius: 6px;">

                @if($req->priorityLevel == 1)
                High
                @elseif($req->priorityLevel == 2)
                Medium
                @elseif($req->priorityLevel == 3)
                Low
                @endif
            </div>

            @endif
<<<<<<< HEAD
            
            <div class="mt-4 mb-4">
                <div class="flex flex-row items-center justify-center gap-2 text-[#2e5e91] border rounded-md p-2 h-auto">
                    <h3 class="font-semibold">Category - </h3>
                    <span class="font-bold">
                        {{ $req->categories->pluck('category.name')->join(', ') }}
                        {{ $req->categories->whereNotNull('ifOthers')->pluck('ifOthers')->join(', ') }}
                    </span>
                </div>
=======

            <div class=" mt-4">
                <span class="font-bold">
                    {{ $req->categories->pluck('category.name')->join(', ') }}
                    {{$req->categories->whereNotNull('ifOthers')->pluck('ifOthers')->join(', ');}}
                </span>

>>>>>>> upstream/main
            </div>

            <!-- Location -->
            <div class="mt-3">
                <h3 class="font-semibold mt-2 mb-1">Location</h3>
                <div class="flex gap-4 border p-4 h-auto rounded-md">
                    <div>College: <span class="font-bold">{{$req->faculty->college}}</span></div>
                    <div>Building: <span class="font-bold">{{$req->faculty->building}}</span></div>
                    <div>Room: <span class="font-bold">{{$req->faculty->room}}</span></div>
                </div>
            </div>

            <!-- Concerns Section -->
            <div class="mt-3">
                <h3 class="font-semibold mt-2 mb-1">Concerns</h3>
                <div class="border p-4 h-56 overflow-auto rounded-md text-md">
                    {{$req->concerns}}
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Task List + Actions -->
        <div class="bg-white px-4 rounded-md shadow text-[18px] text-blue font-semibold h-[100vh]">

            <livewire:assinged-request />
            
            <div class="mt-4">
                @switch(session('user')['role'])
                @case('Mis Staff')
                @include('components.requests.mis')
                @break
                @case('Faculty')
                @include('components.requests.faculty')
                @break
                @case('Technical Staff')
                @include('components.requests.technicalStaff')
                @break
                @endswitch
            </div>

            <!-- Add Rate & Feedback Section Here -->
            @include('components.requests.rateAndFeedback')
        </div>

    </div>

    @endforeach
</div>