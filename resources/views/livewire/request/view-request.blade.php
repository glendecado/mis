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
                    <div class="flex flex-row text-blue-950">
                        <div wire:key="{{$req->id}}">
                            <table>
                                <tr>
                                    <td>request from</td>
                                    <td>College</td>
                                    <td>building</td>
                                    <td>room</td>

                                </tr>
                                <tr>
                                    <td>{{$req->faculty->user->name}}</td>
                                    <td>{{$req->faculty->college}}</td>
                                    <td>{{$req->faculty->building}}</td>
                                    <td>{{$req->faculty->room}}</td>
                                </tr>
                            </table>
                            <br>
                            <h1>Request</h1>
                            <table class="w-full text-sm text-center rtl:text-right">
                                <tr>
                                    <td>id</td>
                                    <td>category</td>
                                    <td>concerns</td>
                                    <td>status</td>

                                    @if (Auth::user()->role != 'Faculty')
                                    <td>priority level</td>
                                    @endif

                                </tr>
                                <tr>
                                    <td>{{$req->id}}</td>
                                    <td>{{$req->category}}</td>
                                    <td>{{$req->concerns}}</td>
                                    <td>{{$req->status}}</td>

                                    @if (Auth::user()->role != 'Faculty')

                                    <td>{{$req->priorityLevel}}</td>
                                    @endif

                                </tr>
                            </table>
                            <button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('request-delete', { id: '{{$req->id}}' })">Delete</button>
                        </div>
                        <div>
                            <button @click="$dispatch('view-assigned', {id: {{$req->id}}})">Assign Technical Staff</button>
                        </div>

                        <select wire:change="$dispatch('value-changed', { value: $event.target.value , id: {{$req->id}} })">
                            <option value="1">level 1</option>
                            <option value="2">level 2</option>
                            <option value="3">level 3</option>
                        </select>


                    </div>
                </x-modal>
            </div>
        </div>
        @endforeach


    </div>
    @livewire('task.view-task')
    @livewire('request.update-request')
</div>