
@if(session('user')['role'] == 'Mis Staff')
    @include('components.task.button')
    @include('components.task.modal')
@endif


@foreach($this->viewTechStaff($this->viewAssigned()) as $tech)
    <fieldset class="border rounded-md p-2">
        <legend>Assigned To:</legend>
        {{$tech->user->name}}
    </fieldset>

@endforeach

