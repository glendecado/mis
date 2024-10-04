<div>



    @if (Auth::user()->role == 'Faculty')
    @livewire('request.add-request')
    @endif

    <div class="overflow-hidden flex justify-center mt-2 flex-col items-center gap-2 ">
        @switch(Auth::user()->role)
        @case('Technical Staff')
        <!-- component -->

        <div class="w-fit flex gap-2 rounded-xl bg-white p-2">
            <div>
                <input type="radio" id="1" wire:model.live="status" value="accepted" class="peer hidden" />
                <label for="1" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 hover:text-white transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">Accepted</label>
            </div>

            <div>
                <input type="radio" id="2" wire:model.live="status" value="pending" class="peer hidden" />
                <label for="2" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 hover:text-white transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">Pending</label>
            </div>

            <div>
                <input type="radio" id="3" wire:model.live="status" value="rejected" class="peer hidden" />
                <label for="3" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 hover:text-white transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">Rejected</label>
            </div>
        </div>
        @break

        @default
        <div class="w-fit flex gap-2 rounded-xl bg-white p-2 shadow-2xl">
            <div>
                <input type="radio" id="1" wire:model.live="status" value="" class="peer hidden" />
                <label for="1" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">All</label>
            </div>

            <div>

                <input type="radio" id="2" wire:model.live="status" value="waiting" class="peer hidden" />
                <label for="2" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 hover:text-white transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">waiting</label>
            </div>

            <div>
                <input type="radio" id="3" wire:model.live="status" value="pending" class="peer hidden" />
                <label for="3" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 hover:text-white transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">Pending</label>
            </div>

            <div>
                <input type="radio" id="4" wire:model.live="status" value="ongoing" class="peer hidden" />
                <label for="4" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 hover:text-white transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">Ongoing</label>
            </div>

            <div>
                <input type="radio" id="5" wire:model.live="status" value="resolve" class="peer hidden" />
                <label for="5" class="block cursor-pointer select-none rounded-xl p-2 text-center hover:bg-blue-400 hover:text-white transition duration-300 peer-checked:bg-blue-400 peer-checked:font-bold peer-checked:text-white">Resolve</label>
            </div>


        </div>

        @break
        @endswitch


        @foreach ($request as $req)



        <div class=" flex flex-col md:flex-row gap-x-4 justify-center items-center overflow-auto text-pretty bg-blue-400 text-white w-[80%] p-2 rounded-lg mx-2 md:mx-0 shadow-md">
            <div>
                <span class=" text-sm">Request ID:</span>
                <u class="bg-blue-900 p-2 rounded-lg">{{$req->id}}</u>
            </div>

            <div class="flex items-center flex-col md:flex-row">
                <img src="{{asset('storage/'.$req->faculty->user->img)}}" class="rounded-[100%] w-20 h-20 object-cover bg-blue-100">
            </div>

            <div class="w-40">
                <span class="text-sm">from: </span>{{$req->faculty->user->name}}
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-[10px]">category:</span><br>
                        <u class="text-sm">{{$req->category->name}}</u>
                    </div>
                    <div>status:
                        <u class="text-sm">{{$req->status}}</u>
                    </div>
                </div>
                <div class="border rounded-lg p-2 w-[300px] h-20 bg-blue-900 overflow-auto">
                    {{$req->concerns}}
                </div>
            </div>

            <div class="text-sm">
                date: <u>{{date_format($req['created_at'], "Y/m/d")}}</u> <br>
                time: <u>{{date_format($req['created_at'], "g:ia")}}</u>
            </div>

            <div class="p-2 w-max">
                <button type="button" @click="$dispatch('open-modal', 'view-request-{{$req->id}}');">View</button>
                <x-modal name="view-request-{{$req->id}}" color="bg-blue-900">

                    {{--card--}}
                    <div class="h-max w-full bg-gray-400 flex flex-col rounded-md gap-2 p-5">

                        {{--I col tracking, date, tome--}}
                        <div class="flex gap-2 justify-items-stretch md:flex-row flex-col w-[100%]">

                            {{--div for tracking--}}
                            <div class="flex flex-col w-[100%]">
                                <label for="trackingNum" class="text-gray-600">Tracking #</label>
                                <input type="text" name="trackingNum" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{$req->id}}">
                            </div>

                            {{--div for date--}}
                            <div class="flex flex-col w-[100%]">
                                <label for="date" class="text-gray-600">Date:</label>
                                <input type="text" name="date" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{date_format($req['created_at'], "Y/m/d")}}">
                            </div>

                            {{--div for time--}}
                            <div class="flex flex-col w-[100%]">
                                <label for="time" class="text-gray-600">Time</label>
                                <input type="text" name="time" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{date_format($req['created_at'], "g:ia")}}">
                            </div>

                        </div>

                        {{--II col category, priority level--}}
                        <div class="flex items-center gap-2 flex-col md:flex-row">

                            {{--div for category--}}
                            <div class="flex flex-col w-full">
                                <label for="category" class="text-gray-600">Category</label>
                                <input type="text" name="category" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{$req->category->name}}">

                            </div>

                            {{--div for priority level--}}
                            <div class="text-black flex flex-col w-full">
                                {{----}}

                                @if (Auth::user()->role == 'Mis Staff') {{--if user is mis staff--}}

                                <label for="Priority" class="text-gray-600">Priority Level</label>
                                <select wire:change="$dispatch('value-changed', { value: $event.target.value, id: {{$req->id}} })" class="w-[100%]">
                                    <option value="1" @if($req->priorityLevel == 1) selected @endif>Level 1</option>
                                    <option value="2" @if($req->priorityLevel == 2) selected @endif>Level 2</option>
                                    <option value="3" @if($req->priorityLevel == 3) selected @endif>Level 3</option>
                                </select>

                                @elseif(Auth::user()->role == 'Technical Staff'){{--if user is Technical Staff--}}

                                <label for="Priority" class="text-gray-600">Priority Level</label>
                                <input type="text" name="Priority" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{$req->priorityLevel }}">

                                @endif

                                {{----}}
                            </div>

                        </div>
                        {{--III col name--}}
                        <div>
                            {{--div for name--}}
                            <div class="flex flex-col">
                                <label for="name" class="text-gray-600">Name</label>
                                <input type="text" name="name" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{$req->faculty->user->name}}">
                            </div>


                        </div>

                        {{--IV col concerns--}}
                        <div>

                            {{--div for concerns--}}
                            <div class="flex flex-col">
                                <label for="category" class="text-gray-600">Concerns</label>
                                <textarea name="" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-5 placeholder-blue-950 h-[200px]" placeholder="{{$req->concerns}}"></textarea>

                            </div>


                        </div>
                        {{--V col assign and accept reject--}}

                        <div class="border border-blue-900 p-2 rounded-md">

                            {{--if user is mis staff then you can assign technical staff--}}
                            @if (Auth::user()->role == 'Mis Staff')

                            <button @click="$dispatch('view-assigned', {id: {{$req->id}}})" class="bg-white text-blue-950 border border-blue-950 p-2 rounded-md">Assign Technical Staff</button>

                            <button @click="$dispatch('request-delete',{id: {{$req->id}}})">Delete Request</button>

                            {{--if user is technical staff then you can accept or reject the request--}}
                            @elseif(Auth::user()->role == 'Technical Staff')

                            @if($req->task->status == 'accepted')

                            {{--category--}}
                            @livewire('task-list.view-list', ['request' => $req])


                            @else
                            <div class="flex justify-between">

                                <button @click="$dispatch('accept-task', {id: {{$req->id}}})" class="bg-white text-blue-950 border border-blue-950 p-2 rounded-md w-56">Accept</button>

                                <button @click="$dispatch('reject-task', {id: {{$req->id}}})" class="bg-white text-blue-950 border border-blue-950 p-2 rounded-md w-56">Reject</button>
                            </div>
                            @endif
                            @elseif(Auth::user()->role == 'Faculty')
                            <div class="h-5 bg-blue-400 text-blue-300 " style="width: {{ $req->progress }}%;">

                                {{ $req->progress }}%
                            </div>

                            @endif
                        </div>

                    </div>
                </x-modal>
            </div>
        </div>
        @endforeach


    </div>

    @livewire('task.update-task')
    @livewire('task.view-task')
    @livewire('request.update-request')
    @livewire('request.delete-request')

    <div wire:loading wire:target="status" class="w-full">
        <div class="fixed inset-0 z-50 flex justify-center items-center bg-blue-950/50">
            <div role="status">
                <svg aria-hidden="true" class="inline w-10 h-10 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>