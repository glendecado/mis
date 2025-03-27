@switch(session('user')['role'])
    @case('Mis Staff')
        @include('components.task-per-request.mis')
        @break

    @case('Technical Staff')
        <p>Welcome, Technical Staff</p>
        @break
@endswitch
