@if($page == 'category' )

    @include('components.task-list.manage-task-list')

@elseif($page == 'request')
    @include('components.task-list.request-task-list')
@endif

