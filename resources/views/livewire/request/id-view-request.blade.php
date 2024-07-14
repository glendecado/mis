<button type="button" @click="$dispatch('view-request', {id: {{$req->id}}})">view </button>

<x-modal name="view-request-{{$req->id}}">
    <div class="flex flex-row">
        <div wire:key="{{$request->id ?? ''}}">
            <table>
                <tr>
                    <td>request from</td>
                    <td>College</td>
                    <td>building</td>
                    <td>room</td>
                </tr>
                <tr>
                    <td>{{$request->faculty->user->name ?? ''}}</td>
                    <td>{{$request->faculty->college ?? ''}}</td>
                    <td>{{$request->faculty->building ?? ''}}</td>
                    <td>{{$request->faculty->room ?? ''}}</td>
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
                    <td>{{$request->id ?? ''}}</td>
                    <td>{{$request->category ?? ''}}</td>
                    <td>{{$request->concerns ?? ''}}</td>
                    <td>{{$request->status ?? ''}}</td>
                </tr>
            </table>
            <button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('request-delete', { id: '{{$request->id ?? ''}}' })">Delete</button>
        </div>
        <div>
            <button @click="$dispatch('view-assigned', {id: {{$request->id ?? ''}}})">Assign Technical Staff</button>

        </div>
    </div>

</x-modal>
@livewire('task.task')
