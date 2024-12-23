
@foreach($this->viewTaskList() as $list)
<div class="text-blue-950 text-lg">
    <div class="border-2 border-blue-500 rounded-md p-4 mb-2 hover:bg-blue-50">
        {{$list->task}}

        @if(session('page') != 'request')
        <span class="float-right cursor-pointer" wire:click="deleteTaskList({{$list->id}})">
            <x-icons.delete />
        </span>
        @endif

    </div>
</div>

@endforeach

@switch(session('page'))

    @case('category')

    <div class="x gap-2">
        <div class="y w-96">
            <input type="text" wire:model="task" class="input">
            
            <!-- Show error message if there's an error for the 'task' field -->
            @error('task')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex-none">
            <button class="button" wire:click.prevent="addTaskList">+</button>
        </div>

    </div>

    @break

    @case('request')
        @if($this->viewTaskList()->isEmpty())
            <span>No Task List Found</span>
            <a href="/category" class="text-blue underline">proceed to this link to add task on a categoy...</a>

        @else
            <div class="float-end">
                @include('components.assigned-request.button')
            </div>
        @endif
    @break

@endswitch
