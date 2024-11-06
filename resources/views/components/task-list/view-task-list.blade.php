@if(session('page') == 'requests' || session('page') == 'request')
    @include('components.task-list.request-task-list')
@else
    @include('components.task-list.manage-task-list')

@endif
