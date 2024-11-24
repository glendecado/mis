@if(session('user')['role'] == 'Mis Staff')
@include('components.task.modal')
@endif


@foreach($this->viewTechStaff($this->viewAssigned()) as $tech)

<fieldset class="border p-2 rounded-md">
    <legend>Assigned to</legend>
    <div class="x gap-5 rounded-md">
        {{$tech->user->name ?? 'Not assigned to any technical staff yet!'}}
    </div>
</fieldset>

@endforeach