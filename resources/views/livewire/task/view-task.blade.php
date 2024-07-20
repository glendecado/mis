<div>

    @foreach($request as $req)
    <x-modal name="assigned-{{$req->id ?? ''}}">
        {{$req->id ?? ''}}


        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Ongoing</th>
                    <th>Pending</th>
                    <th>Resolve</th>
                    <th>Assign</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($technicalStaff as $tech)

                <tr>
                    <td>{{$tech->user->name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        @if (in_array($tech->user->id, $task))
                        <button class="bg-blue-900 text-white" @click="$dispatch('add-task', {request_id: '{{$req->id ?? ''}}', tech_id: '{{$tech->user->id}}'}); $dispatch('update-task')">add</button>
                        @else
                        <button class="bg-slate-200" @click="$dispatch('add-task', {request_id: '{{$req->id ?? ''}}', tech_id: '{{$tech->user->id}}'}) ; $dispatch('update-task')">add</button>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-modal>
    @endforeach
</div>