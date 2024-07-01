
@include('request.add-request')


<select wire:model.change="selecStatus">
    <option value="All">All</option>
    <option value="Waiting">Waiting</option>
    <option value="Pending">Pending</option>
    <option value="Ongoing">Ongoing</option>
    <option value="Resolved">Resolved</option>
</select>

{{$selecStatus}}

@include('request.table-request')
{{$requests->links()}}