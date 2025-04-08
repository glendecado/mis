<?php

use App\Events\RequestEvent;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Request;
use App\Models\TaskList;
use App\Models\User;
use App\Notifications\RequestStatus;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{state, rules};

state(['checked', 'page']);
state(['category', 'task', 'request', 'editingId' => null, 'editedTask' => '']);

rules([
    'task' => 'required',
    'editedTask' => 'required'
]);

$addTaskList = function () {
    $this->validate(['task' => 'required']);

    $existingTask = TaskList::where('category_id', $this->category)
        ->where('task', $this->task)
        ->first();

    if ($existingTask) {
        $this->dispatch('danger', 'Task already exists in this category');
        return;
    }

    $taskList = TaskList::create([
        'category_id' => $this->category,
        'task' => $this->task,
        'status' => 'enabled',
    ]);

    $taskList->save();
    $this->reset('task');
    $this->category = $taskList->category_id;
    $this->dispatch('success', 'Task Successfully added');
};

$updateStatus = function ($id) {
    $list = TaskList::find($id);

    if ($list) {
        $list->status = ($list->status === 'enabled') ? 'disabled' : 'enabled';
        $list->save();
    }
};

$editTask = function ($id) {
    $this->editingId = $id;
    $task = TaskList::find($id);
    $this->editedTask = $task->task;
};

$updateTask = function ($id) {
    $this->validate(['editedTask' => 'required']);
    
    $task = TaskList::find($id);
    if ($task) {
        $task->task = $this->editedTask;
        $task->save();
        $this->cancelEdit();
        $this->dispatch('success', 'Task updated successfully');
    }
};

$cancelEdit = function () {
    $this->editingId = null;
    $this->editedTask = '';
};


$viewTaskList = function () {
    return TaskList::where('category_id', $this->category)->get();
};
?>

<div class="relative rounded-md">
    <ul>
        @foreach($this->viewTaskList() as $list)
        <li class="text-blue-950 text-lg">
            <div style="border: 1px solid #2e5e91; border-radius: 6px; padding: 8px; margin-bottom: 8px;"
                class="flex w-full flex-col md:flex-row items-center justify-between gap-2 {{$list->status == 'disabled' ? 'bg-slate-300 hover:bg-slate-400' : 'hover:bg-blue-50'}}">


                @if($editingId === $list->id)
                    <div class="flex flex-col">
                        <input type="text" wire:model="editedTask" class="input w-full text-sm border bg-white">
                        @error('editedTask')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="updateTask({{$list->id}})" class="text-sm px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Save
                        </button>
                        <button wire:click="cancelEdit" class="text-sm px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                @else




                    <span class="whitespace-normal break-words flex-1 text-sm font-medium relative truncate w-full ">
                        {{$list->task}}
                    </span>
                    <div class="flex gap-2">
                        <button type="button" wire:loading.attr="disabled" @click="$wire.updateStatus({{$list->id}})" class="text-sm px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            {{ ucfirst($list->status) }}
                        </button>
                        @if(session('page') === 'category')
                            <button wire:click="editTask({{$list->id}})" class="text-sm px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Edit
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </li>
        @endforeach
    </ul>

    @switch(session('page'))
    @case('category')
    <div class="md:x y gap-2 flex items-center justify-between">
        <div class="flex flex-col md:flex-row items-start gap-2 w-[100%] md:w-full ">
            <div class="w-full md:w-[80%]">
                <input type="text" wire:model="task" class="input w-full text-sm border bg-[#2e5e91]" placeholder="Enter task item...">
                @error('task')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex-none">
                <button class="w-20 text-white font-medium rounded-md px-4 py-2 text-sm bg-[#3E7B27]" wire:click.prevent="addTaskList">Add</button>
            </div>
        </div>
    </div>
    @break






    @case('request')
    @if($this->viewTaskList()->isEmpty())
    <div class="flex flex-col">
        <span class="text-red-500 font-semibold text-[16px]">No Task List Found.</span>
        <a href="/category" class="text-blue underline text-[16px]">Proceed to this link to add task on a category...</a>
    </div>
    @else
    <div class="float-end">
        @include('components.assigned-request.button')
    </div>
    @endif
    @break
    @endswitch
</div>