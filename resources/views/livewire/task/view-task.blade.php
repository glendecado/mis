<div>
    @livewire('task.add-task')

    <x-modal name="assigned">
        @if(isset($id))
        @switch(Auth::user()->role)

        {{--IF THE USER IS MIS STAFF--}}
        @case('Mis Staff')

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-blue-950 text-white text-left">
                    <th class="py-3 px-6">Name</th>
                    <th class="py-3 px-6">Pending</th>
                    <th class="py-3 px-6">Ongoing</th>
                    <th class="py-3 px-6">Resolve</th>
                    <th class="py-3 px-6">Assign</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($technicalStaff as $tech)
                <tr class="border-b border-gray-300 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $tech->user->name }}</td>
                    <td class="py-3 px-6">
                        {{$tech->totalPendingTask}}
                    </td>
                    <td class="py-3 px-6">{{$tech->totalOngoingTask}}</td>
                    <td class="py-3 px-6 text-center">
                        {{-- Number of resolved tasks goes here --}}
                    </td>
                    <td class="py-3 px-6">
                        @if (in_array($tech->user->id, $task))
                        <button class="bg-blue-900 text-white py-2 px-4 rounded shadow-md hover:bg-blue-700"
                            @click="$dispatch('add-task', {request_id: '{{ $id ?? '' }}', tech_id: '{{ $tech->user->id }}' }); 
                                $dispatch('view-task'); 
                                $dispatch('view-request')">
                            Assigned
                        </button>
                        @else
                        <button class="bg-gray-200 text-gray-800 py-2 px-4 rounded shadow-md hover:bg-gray-300"
                            @click="$dispatch('add-task', {request_id: '{{ $id ?? '' }}', tech_id: '{{ $tech->user->id }}' }); 
                                $dispatch('view-task'); 
                                $dispatch('view-request')">
                            Add
                        </button>
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