@if(session('page') == 'request' )
    @include('components.task-list.request-task-list')
@elseif(session('page') == 'admin-panel')
    @include('components.task-list.manage-task-list')

@endif
