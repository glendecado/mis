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

                <div class="p-2 text-white text-sm rounded-md leading-none flex bg-[#3D8D7A]">
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
                Priority Level:
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
                        class="input border p-2 rounded-md w-full"
                        wire:change="priorityLevelUpdate($event.target.value)"
                        style="background-color: 
                            {{ $req->priorityLevel == 1 ? '#EE4E4E' : ($req->priorityLevel == 2 ? '#FFC145' : '#77B254') }};
                            color: {{ $req->priorityLevel == 2 ? 'black' : 'white' }};
                            padding: 6px;
                            border-radius: 6px;
                            transition: background-color 0.3s ease;">
                        <option value="1" @if($req->priorityLevel == 1) selected @endif
                            style="background-color: #EE4E4E; color: white;">High</option>
                        <option value="2" @if($req->priorityLevel == 2) selected @endif
                            style="background-color: #FFC145; color: white;">Medium</option>
                        <option value="3" @if($req->priorityLevel == 3) selected @endif
                            style="background-color: #77B254; color: white;">Low</option>
                    </select>

                </div>
                @endif
            </div>
            @break
            @endswitch
            @else
            Priority Level
            <div class="priority-label"
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

            <div class=" mt-4">
                <span class="font-bold">
                {{ $req->categories->pluck('category.name')->join(', ') }}
                {{$req->categories->whereNotNull('ifOthers')->pluck('ifOthers')->join(', ');}}
                </span>

            </div>

            <!-- Location -->
            <fieldset class="border p-2 rounded-md mt-4">
                <legend class="font-semibold">Location</legend>
                <div class="flex gap-4">
                    <div>College: <span class="font-bold">{{$req->faculty->college}}</span></div>
                    <div>Building: <span class="font-bold">{{$req->faculty->building}}</span></div>
                    <div>Room: <span class="font-bold">{{$req->faculty->room}}</span></div>
                </div>
            </fieldset>

            <!-- Concerns Section -->
            <div class="mt-6">
                <h3 class="font-semibold mt-4">Concerns</h3>
                <div class="border p-4 h-56 overflow-auto rounded-lg text-md">
                    {{$req->concerns}}
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Task List + Actions -->
        <div class="bg-white px-4 rounded-md shadow text-2xl text-blue font-semibold h-[100vh]">
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