
@if(session('user')['role'] == 'Mis Staff')
    @include('components.task.button')
    @include('components.task.modal')
@endif


@foreach($this->viewTechStaff($this->viewAssigned()) as $tech)
    <div>
        {{$tech->user->name}}
    </div>

@endforeach

