@if(session('user')['role'] == 'Mis Staff')
@include('components.task.modal')
@endif


@foreach($this->viewTechStaff($this->viewAssigned()) as $tech)

<div class="flex flex-col">
    {{$tech->user->name ?? 'Not assigned to any technical staff yet!'}}
</div>

@endforeach