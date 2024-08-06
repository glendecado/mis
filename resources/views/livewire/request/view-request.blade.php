<div>
    @livewire('request.delete-request')

    @if (Auth::user()->role == 'Faculty')
    @livewire('request.add-request')
    @endif

    <div class="overflow-hidden flex justify-center mt-2 flex-col items-center gap-2">
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
                            <table>
                                <tr>
                                    <td>id</td>
                                    <td>category</td>
                                    <td>concerns</td>
                                    <td>status</td>
                                </tr>
                                <tr>
                                    <td>{{$req->id}}</td>
                                    <td>{{$req->category}}</td>
                                    <td>{{$req->concerns}}</td>
                                    <td>{{$req->status}}</td>
                                </tr>
                            </table>
                            <button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('request-delete', { id: '{{$req->id}}' })">Delete</button>
                        </div>
                        <div>
                            <button @click="$dispatch('view-assigned', {id: {{$req->id}}})">Assign Technical Staff</button>
                        </div>
                    </div>
                </x-modal>
            </div>
        </div>
        @endforeach

        @livewire('task.view-task')
    </div>
</div>