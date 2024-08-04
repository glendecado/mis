<div>
    @livewire('request.delete-request')

    @if (Auth::user()->role == 'Faculty')
    @livewire('request.add-request')
    @endif



    <div class="overflow-hidden">


        @foreach ($request as $req)
        <div class="border bg-blue-950 gap-4 grid grid-rows-4 text-white p-4 m-4 rounded-md md:grid-rows-1 md:grid-cols-4 ">

            <div class="text-center flex flex-col">from: {{$req->faculty->user->name}}
                <span wire:key="{{$req->id }}" class="mt-4">Request ID: {{$req['id']}}</span>
            </div>

            <div class="w-[100%]">Category: {{$req['category']}}<br><textarea disabled class="p-2 resize-none w-full rounded-md overflow-auto">{{$req['concerns']}}</textarea></div>

            <div class="flex flex-row items-center gap-2">
                <div>date:
                    <span class="bg-blue-100 p-1 rounded-md text-blue-950">
                        {{date_format($req['created_at'], "Y/m/d")}}
                    </span>
                </div>

                <div>time:
                    <span class="bg-blue-100 p-1 rounded-md text-blue-950">
                        {{date_format($req['created_at'], "g:ia")}}</span>
                </div>
                <div>Status: {{$req['status']}}</div>
            </div>

            <div class="text-center">
                {{--view--}}
                <button type="button" @click="$dispatch('open-modal',  'view-request-{{$req->id}}');">View </button>
                <x-modal name="view-request-{{$req->id}}">
                    <div class="flex flex-row text-blue-950">
                        <div wire:key="{{$req->id }}">
                            <table>
                                <tr>
                                    <td>request from</td>
                                    <td>College</td>
                                    <td>building</td>
                                    <td>room</td>
                                </tr>
                                <tr>
                                    <td>{{$req->faculty->user->name }}</td>
                                    <td>{{$req->faculty->college }}</td>
                                    <td>{{$req->faculty->building }}</td>
                                    <td>{{$req->faculty->room }}</td>
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
                                    <td>{{$req->id }}</td>
                                    <td>{{$req->category }}</td>
                                    <td>{{$req->concerns }}</td>
                                    <td>{{$req->status }}</td>
                                </tr>
                            </table>
                            <button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('request-delete', { id: '{{$req->id }}' })">Delete</button>
                        </div>
                        <div>
                            <button @click="$dispatch('view-assigned', {id: {{$req->id }}})">Assign Technical Staff</button>

                        </div>
                    </div>

                </x-modal>

            </div>
        </div>

        @endforeach

        @livewire('task.view-task')
    </div>