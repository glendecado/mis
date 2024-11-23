@if(session('user')['role'] == 'Mis Staff' )

    @include('components.task-list.manage-task-list')

@elseif(session('user')['role'] == 'Technical Staff')

    @include('components.task-list.request-task-list')
    
@endif

