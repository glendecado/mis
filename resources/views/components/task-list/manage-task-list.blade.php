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
        <span class="float-right cursor-pointer" wire:click="deleteTaskList({{$list->id}})">X</span>
    </div>
</div>

@endforeach
<div>
    <input type="text" wire:model="task" class="input">
    <button class="button" wire:click.prevent="addTaskList">Add</button>
</div>

<div class="float-end">
    @include('components.task.button')
</div>

@endif