@switch(session('user')['role'])
    @case('Mis Staff')
        @include('components.task-per-request.mis')
        @break

    @case('Technical Staff')
        @include('components.task-per-request.tech-staff')
        @break
@endswitch
