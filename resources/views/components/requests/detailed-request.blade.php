<div class="w-full bg-blue-50 rounded-md p-4 shadow-md">
    @foreach($this->viewDetailedRequest() as $req)

    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4"> 
        <!-- LEFT COLUMN: Faculty Info + Concerns -->
        <div class="bg-white p-4 rounded-md shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 mb-10">
                    <img src="{{asset('storage/'.$req->faculty->user->img)}}" alt="" class="size-16 rounded-full">
                    <div>
                        <span class="text-lg font-bold block">{{$req->faculty->user->name}}</span>
                        <span class="text-sm">
                            Date: <span class="font-bold">{{$req->created_at->format('Y-m-d')}}</span>
                            Time: <span class="font-bold">{{$req->created_at->format('h:i A')}}</span>
                        </span>
                    </div>
                </div>

                <div class="mt-3 p-2 bg-yellow text-blue rounded-md">
                    Status: <span class="font-bold">{{$req->status}}</span>
                </div>
            </div>

            @if($req->status == 'pending' || session('user')['role'])
            <!-- Priority -->
            <span class="text-sm text-blue"> You can now assign a priority level.</span>
            @endif

            @switch(session('user')['role'])
                @case('Mis Staff')
                <div class="mt-2">
                    @if($req->status == 'ongoing' || $req->status == 'resolved')
                        Priority level:
                        <span class="font-bold">
                            {{$req->priorityLevel == 3 ? 'Low' : ($req->priorityLevel == 2 ? 'Medium' : 'High')}}
                        </span>
                    @elseif($req->status == 'pending')
                        <div class="mb-2">
                            <label for="prio">Priority Level:</label>
                            <select id="prio" class="input border p-2 rounded-md w-full" wire:change="priorityLevelUpdate($event.target.value)">
                                <option value="1" @if($req->priorityLevel == 1) selected @endif>High</option>
                                <option value="2" @if($req->priorityLevel == 2) selected @endif>Medium</option>
                                <option value="3" @if($req->priorityLevel == 3) selected @endif>Low</option>
                            </select>
                        </div>
                    @endif
                </div>
                @break
            @endswitch

            <div class="mt-4">
                Category: <span class="font-bold">{{$req->category->name}}</span>
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
                <div class="border p-4 h-56 overflow-auto rounded-lg text-sm">
                    {{$req->concerns}}
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Task List + Actions -->
        <div class="bg-white px-4 rounded-md shadow text-2xl text-blue font-semibold">
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
        </div>
    </div>

    @endforeach

    @include('components.requests.rateAndFeedback')
</div>