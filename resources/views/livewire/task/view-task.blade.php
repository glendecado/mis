<div>
    @livewire('task.add-task')

    <x-modal name="assigned">
        @if(isset($id))
        @switch(Auth::user()->role)

        {{--IF THE USER IS MIS STAFF--}}
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
                    <td></td>
                    <td></td>
                    <td>
                        @if (in_array($tech->user->id, $task))
                        <button class="bg-blue-900 text-white" @click="$dispatch('add-task', {request_id: '{{$id ?? ''}}', tech_id: '{{$tech->user->id}}'}); $dispatch('update-task'); $dispatch('update-request')">add</button>
                        @else
                        <button class="bg-slate-200" @click="$dispatch('add-task', {request_id: '{{$id ?? ''}}', tech_id: '{{$tech->user->id}}'}) ; $dispatch('update-task');$dispatch('update-request')">add</button>
                        @endif

                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>


        @break

        {{--IF THE USER IS FACULTY--}}
        @case('Faculty')

        @foreach ($technicalStaff as $tech)

        @if (in_array($tech->user->id, $task))
        {{$tech->user->name}}
        @endif

        @endforeach

        @break


        {{--IF THE USER IS Technical Staff--}}
        @case('Technical Staff')

        @break


        @endswitch
        @endif
    </x-modal>

</div>