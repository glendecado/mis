<div class="request-parent flex gap-4 flex-col">
    @foreach($this->viewDetailedRequest() as $req)

    <div class="w-full">
        <div x-on:click="window.history.back()">
            <div class="float-right border rounded-full size-8 flex-center">
                <x-icons.arrow direction="left" />
            </div>
        </div>

    </div>

    <div class="request-containder">

        <div class="w-full flex  justify-between items-center">

            <div class="x items-center gap-2">
                {{--img name status--}}

                {{--img--}}
                <img src="{{asset('storage/'.$req->faculty->user->img)}}" alt="" class="size-16 rounded-full">

                <div class="y">
                    {{--name--}}
                    <span class="text-lg font-bold">{{$req->faculty->user->name}}</span>
                    {{--Date--}}
                    <span class="text-sm">
                        Date: <span class="font-bold">{{$req->created_at->format('Y-m-d')}}</span>
                        Time: <span class="font-bold">{{$req->created_at->format('h:i A')}}</span>
                    </span>
                </div>
            </div>

            <div>
                status: <span class="font-bold">{{$req->status}}</span>
            </div>

        </div>

        <div class="y mt-2 gap-4">


            <div class="y md:x justify-between ">

                <div>
                    Category: <span class="font-bold">{{$req->category->name}}</span>
                </div>


                @switch(session('user')['role'])

                @case('Mis Staff')
                <div>

                    @if($req->status == 'ongoing' || $req->status == 'resolved')

                    Priority level:
                    <span class="font-bold">
                        {{
                            $req->priorityLevel == 3 ? 'Low' : 
                            ($req->priorityLevel == 2 ? 'Medium' : 
                            ($req->priorityLevel == 1 ? 'High' : ''))}}
                    </span>

                    @elseif($req->status == 'pending')

                    <div>
                        <label for="prio">Priority Level:</label>
                        <select name="" id="prio" class='input' wire:change="priorityLevelUpdate($event.target.value)">
                            <option value="1" @if($req->priorityLevel == 1) selected @endif>1 : High</option>
                            <option value="2" @if($req->priorityLevel == 2) selected @endif>2 : Medium</option>
                            <option value="3" @if($req->priorityLevel == 3) selected @endif>3 : Low</option>
                        </select>
                    </div>

                    <span class="font-thin text-sm"> You can now assign a priority level.</span>

                    @else
                    <span></span>
                    @endif
                </div>
                @break


                @case('Technical Staff')
                Priority level:
                    <span class="font-bold">
                        {{
                            $req->priorityLevel == 3 ? 'Low' : 
                            ($req->priorityLevel == 2 ? 'Medium' : 
                            ($req->priorityLevel == 1 ? 'High' : ''))}}
                    </span>
                @break
                @default
                <span></span>
                @break

                @endswitch   
            </div>

            <fieldset class="border p-2 rounded-md">
                <legend>Location</legend>
                <div class="x gap-5 rounded-md">

                    <div>
                        College:
                        <span class="font-bold">{{$req->faculty->college}}</span>

                    </div>

                    <div>
                        Building:
                        <span class="font-bold">{{$req->faculty->building}}</span>
                    </div>

                    <div>
                        Room:
                        <span class="font-bold">{{$req->faculty->room}}</span>
                    </div>

                </div>
            </fieldset>


            <livewire:task />



            <div>
                Concern(s):
                <div class=" border p-3 shadow-lg h-56 overflow-auto rounded-md">
                    {{$req->concerns}}
                </div>
            </div>

        </div>

    </div>


    <div>
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

    @endforeach


</div>