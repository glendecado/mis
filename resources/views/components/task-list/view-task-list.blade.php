@if(session('page') != 'admin-panel' )
    @include('components.task-list.request-task-list')
@else
    @include('components.task-list.manage-task-list')

@endif
