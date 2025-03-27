<?php

use App\Models\Categories;
use App\Models\Category;
use App\Models\TaskList;
use App\Models\TaskPerRequest;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{mount, on, state};

state('categories', []);
state('taskList', []);
state('selectedTaskList', []);
state('taskPerReq', []);
state('notDefault');

on(['reqPerTask' => function () {
    $this->taskPerReq = DB::table('task_per_requests')->where('request_id', session()->get('requestId'))->get();
}]);


mount(function () {

    $requestId = session('requestId');

    $this->categories = DB::table('categories')
        ->where('request_id', $requestId)
        ->select('id', 'category_id', 'ifOthers', 'toDefault') // Select multiple columns
        ->get();


    $categoriesId = $this->categories->pluck('category_id')->toArray();



    $this->taskList = DB::table('task_lists')->whereIn('category_id', $categoriesId)
        ->where('status', 'enabled')
        ->pluck('task', 'id');

    $this->taskPerReq = DB::table('task_per_requests')->where('request_id', session()->get('requestId'))->get();

    $this->notDefault = $this->categories
        ->whereNotNull('ifOthers') // Filters out records where 'ifOthers' is NULL
        ->where('toDefault', '!==', 0) // Filters out records where 'toDefault' is exactly false
        ->toArray(); // Converts the result to an array

});

$confirmTask = function () {

    $tasks = DB::table('task_lists')->whereIn('id', $this->selectedTaskList)->get();
    foreach ($tasks as $task) {
        $taskPerReq = TaskPerRequest::create([
            'request_id' => session()->get('requestId'),
            'task' => $task->task,
            'status' => 'enable'
        ]);
        $taskPerReq->save();
    }

    $this->dispatch('reqPerTask');
};





$toDefaultCategory = function ($name, $decide) {

    $catCollection = Categories::where('ifOthers', $name)->get();

    if ($decide) {
        $defCat = Category::create([
            'name' => $name
        ]);

        //remove the name and then put the category with name
        foreach ($catCollection as $cat) {
            $cat->category_id = $defCat->id;
            $cat->ifOthers = null;
            $cat->save(); // Save each updated record
        }
        $defCat->save();
        $this->dispatch('success', 'Successfully save as default; you can now set a task list for this category.');
        return $this->redirect('/category', navigate: true);
    } else {
        foreach ($catCollection as $cat) {
            $cat->toDefault = false;
            $cat->save();
        }
        return $this->redirect('/request/' . session()->get('requestId'), navigate: true);
    }
};
?>



<div>

    @if($taskList->isEmpty())

    @if(count($this->notDefault) > 1 || count($this->categories->toArray()) > 2)
    <p class="text-red-500">No default task</p>
    <a x-navigate href="/category" class="underline text-sm"> Proceed to this link to add default task on a category</a>
    @endif


    @if(count($this->notDefault) == 0 && count($this->categories->toArray()) == 1)
    <h1>No task available for this category.</h1>
    @endif

    @else

    @if($taskPerReq->isEmpty())
    <!-- Open Modal Button -->
    <button @click="$dispatch('open-modal', 'add-task-modal')" class="button">
        Select Task List
    </button>

    <!-- Modal -->
    <x-modal name="add-task-modal">
        <div class="p-4">
            <h2 class="text-lg font-bold mb-3">Select Tasks</h2>

            <!-- Task Checklist -->
            <div class="flex flex-col gap-2"
                x-data="{ 
                taskList: @entangle('taskList'), 
                selectedTaskList: @entangle('selectedTaskList') ,
                selectAll : '',
                 init() {
                // Initialize selectedTaskList with all IDs when component loads
                this.selectedTaskList = Object.keys(this.taskList).map(id => id.toString());
                this.selectAll = true;
            },
            selectAllFunction() {
                this.selectedTaskList = Object.keys(this.taskList).map(id => id.toString());
                this.selectAll = true;
            },
            unselectAllFunction() {
                    this.selectedTaskList = [];
                    this.selectAll = false;
                },
            selectCondition() {
                let t = Object.keys(this.taskList).length;
                let s = Object.keys(this.selectedTaskList).length;
                this.selectAll = s === t;
            }

            }">


                <label class="text-sm cursor-pointer flex items-center space-x-2">
                    <input type="checkbox"
                        x-model="selectAll"
                        @change="selectAll ? selectAllFunction() : unselectAllFunction()"
                        class="hidden peer">

                    <!-- Checkbox UI -->
                    <div class="w-5 h-5 flex items-center justify-center border border-gray-400 rounded-full 
                peer-checked:bg-blue transition-all duration-300">
                        <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                    </div>

                    <span>Select all</span>
                </label>


                <template x-for="(task, id) in taskList" :key="id">
                    <label class="flex items-center space-x-2 p-2 border rounded">
                        <input type="checkbox" x-model="selectedTaskList" :value="id" class="form-checkbox hidden peer" @change="selectCondition;">
                        <!-- Checkbox UI -->
                        <div class="w-5 h-5 flex items-center justify-center border border-blue rounded-full 
                peer-checked:bg-blue transition-all duration-300">
                            <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                        </div>

                        <span x-text="task"></span>
                    </label>
                </template>
            </div>


            <!-- Confirm Button -->
            <div class="mt-4">
                <button wire:click="confirmTask" class="button-primary">
                    Confirm
                </button>
            </div>
        </div>
    </x-modal>
    @else

    @foreach($taskPerReq as $task)
    <div class="border p-2 rounded-md mb-7">
        {{$task->task}}
    </div>
    <livewire:assinged-request />
    @endforeach

    @endif


    @endif

    @if($this->notDefault)
    <div class="border p-2 rounded-md mt-5">
        <p class="text-sm">there is a category that's not default,
            <span class="underline text-red-500">
                {{implode(', ', $this->categories->whereNotNull('ifOthers')->pluck('ifOthers')->toArray())}}
            </span>
        </p>
        <p class="text-sm">Do you want to add it as a default?</p>
        <div>
            @foreach($this->categories->whereNotNull('ifOthers')->pluck('ifOthers')->toArray()
            as $name)
            <div>
                <button @click="$wire.toDefaultCategory('{{$name}}', true)" class="border p-2 rounded-md bg-green-400 w-20 text-center">Yes</button>
                <button @click="$wire.toDefaultCategory('{{$name}}', false)" class="border p-2 rounded-md bg-red-400 w-20 text-center">No</button>
            </div>
            @endforeach
        </div>

    </div>
    @endif

</div>