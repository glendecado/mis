@if($this->viewTaskList()->isEmpty())

<span>No Task List Found</span>

<div>
    <input type="text" wire:model="task" class="input">
    <button class="button" wire:click.prevent="addTaskList">Add</button>
</div>

@else
@foreach($this->viewTaskList() as $list)
<div class="text-white">
    <div class="bg-blue-300 rounded-md p-2 mb-2">
        {{$list->task}}

        @if(session('page') != 'request')
            <span class="float-right cursor-pointer" wire:click="deleteTaskList({{$list->id}})">X
            </span>
        @endif

    </div>
</div>

@endforeach

    @if(session('page') != 'request')
        <div>
            <input type="text" wire:model="task" class="input">
            <button class="button" wire:click.prevent="addTaskList">Add</button>
        </div>
    @else

        <div class="float-end">
            @include('components.assigned-request.button')
        </div>
    @endif
@endif