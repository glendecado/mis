<div>
    @php
    $technicalStaff = \App\Models\TechnicalStaff::with('user')->get();
    @endphp

    @foreach(\App\Models\Request::all() as $req)
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
                    <td><button @click="$dispatch('add-task', {request_id: '{{$req->id ?? ''}}', tech_id: '{{$tech->user->id}}'})">add</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-modal>
    @endforeach
</div>