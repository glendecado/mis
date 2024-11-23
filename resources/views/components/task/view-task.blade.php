
@if(session('user')['role'] == 'Mis Staff')
    @include('components.task.modal')
@endif


@foreach($this->viewTechStaff($this->viewAssigned()) as $tech)

        {{$tech->user->name ?? 'Not assigned to any technical staff yet!'}}


@endforeach

