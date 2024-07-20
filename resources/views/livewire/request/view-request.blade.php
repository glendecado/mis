<div>
    @livewire('request.delete-request')
    @livewire('request.add-request')
    
    <table border="1">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Faculty ID</th>
                <th>Category</th>
                <th>Concerns</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($request as $req)
            <tr>
                <td wire:key="{{$req->id}}">{{$req['id']}}</td>
                <td>{{$req['faculty_id']}}</td>
                <td>{{$req['category']}}</td>
                <td>{{$req['concerns']}}</td>
                <td>{{date_format($req['created_at'], "Y/m/d")}}</td>
                <td>{{date_format($req['created_at'], "g:i a")}}</td>
                <td>{{$req['status']}}</td>
                <td>

                    <button type="button" @click="$dispatch('open-modal',  'view-request-{{$req->id}}');">View </button>
                    <x-modal name="view-request-{{$req->id}}">
                        <div class="flex flex-row">
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


                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @livewire('task.view-task')
</div>