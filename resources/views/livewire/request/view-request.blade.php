<div>
    @livewire('request.delete-request')

    @if (Auth::user()->role == 'Faculty')
    @livewire('request.add-request')
    @endif

    <div class="overflow-hidden flex justify-center mt-2 flex-col items-center gap-2 ">

        <div>
            <label for="status">Select status:</label>
            <select wire:model.change="status" id="status" class="bg-gray-50 border border-blue-300 text-blue-950 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-56 p-2.5 mb-5">
                <option value="">All</option>
                <option value="waiting">Waiting</option>
                <option value="pending">Pending</option>
            </select>
        </div>

        @foreach ($request as $req)
        <div class="flex flex-col md:flex-row gap-x-4 justify-center items-center overflow-auto text-pretty bg-blue-950 text-white w-[1000px] p-2 rounded-lg mx-2 md:mx-0 shadow-md">
            <div>
                <span class="text-sm">Request ID:</span>
                <u class="bg-blue-900 p-2 rounded-lg">{{$req->id}}</u>
            </div>

            <div class="flex items-center flex-col md:flex-row">
                <img src="{{asset('storage/'.$req->faculty->user->img)}}" class="rounded-[100%] w-20 h-20 object-cover">
            </div>

            <div class="w-40">
                <span class="text-sm">from: </span>{{$req->faculty->user->name}}
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-[10px]">category:</span><br>
                        <u class="text-sm">{{$req->category}}</u>
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
                <button type="button" @click="$dispatch('open-modal',  'view-request-{{$req->id}}');">View</button>
                <x-modal name="view-request-{{$req->id}}">

                    {{--card--}}
                    <div class="h-max w-full bg-gray-400 p-2 flex flex-col rounded-md gap-2 ">

                        {{--I col--}}
                        <div class="flex gap-2 justify-items-stretch md:flex-row flex-col">


                            <div class="flex flex-col">
                                <label for="trackingNum" class="text-gray-600">Tracking #</label>
                                <input type="text" name="trackingNum" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{$req->id}}">
                            </div>


                            <div class="flex flex-col">
                                <label for="trackingNum" class="text-gray-600">Date:</label>
                                <input type="text" name="trackingNum" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{date_format($req['created_at'], "Y/m/d")}}">
                            </div>

                            <div class="flex flex-col">
                                <label for="trackingNum" class="text-gray-600">Time</label>
                                <input type="text" name="trackingNum" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{date_format($req['created_at'], "g:ia")}}">
                            </div>

                        </div>

                        {{--II col--}}
                        <div>

                            <div class="flex flex-col">
                                <label for="trackingNum" class="text-gray-600">Category</label>
                                <input type="text" name="trackingNum" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{$req->category}}">
                            </div>


                        </div>
                        {{--III col--}}
                        <div>

                            <div class="flex flex-col">
                                <label for="trackingNum" class="text-gray-600">Name</label>
                                <input type="text" name="trackingNum" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950" placeholder="{{$req->faculty->user->name}}">
                            </div>


                        </div>

                        {{--IV col--}}
                        <div>
                            <div class="flex flex-col">
                                <label for="trackingNum" class="text-gray-600">Category</label>
                                <textarea name="" id="" disabled class="bg-gray-200 rounded-md border border-blue-900 p-2 placeholder-blue-950 h-[200px]" placeholder="{{$req->concerns}}"></textarea>

                            </div>

                        </div>


                        <div class="border border-blue-900 p-2 rounded-md">
                            <button @click="$dispatch('view-assigned', {id: {{$req->id}}})" class="bg-white text-blue-950 border border-blue-950 p-2 rounded-md">Assign Technical Staff</button>
                        </div>

                    </div>
                </x-modal>
            </div>
        </div>
        @endforeach


    </div>
    @livewire('task.view-task')
    @livewire('request.update-request')
</div>