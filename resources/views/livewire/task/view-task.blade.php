<div>
    @livewire('task.add-task')
    @foreach($request as $req)
    <x-modal name="assigned-{{$req->id ?? ''}}">
        @switch(Auth::user()->role)
        @case('Mis Staff')

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
                    <td>

                        {{--numbers of pending according to assigned technical staff--}}
                        {{
                            DB::table('requests')
                            ->join('tasks', 'requests.id', '=', 'tasks.request_id')
                            ->where('tasks.technicalStaff_id', $tech->user->id)
                            ->where('requests.status', 'pending')
                            ->count()
                        }}
                    </td>
                    <td></td>
                    <td>
                        @if (in_array($tech->user->id, $task))
                        <button class="bg-blue-900 text-white" @click="$dispatch('add-task', {request_id: '{{$req->id ?? ''}}', tech_id: '{{$tech->user->id}}'}); $dispatch('update-task'); $dispatch('update-request')">add</button>
                        @else
                        <button class="bg-slate-200" @click="$dispatch('add-task', {request_id: '{{$req->id ?? ''}}', tech_id: '{{$tech->user->id}}'}) ; $dispatch('update-task');$dispatch('update-request')">add</button>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        @break

        @case('Faculty')

        @foreach ($technicalStaff as $tech)
        @if (in_array($tech->user->id, $task))
        {{$tech->user->name}}
        @endif
        @endforeach

        @break

        @case('Technical Staff')

        @break


        @endswitch

    </x-modal>
    @endforeach
</div>