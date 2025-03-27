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
<<<<<<< HEAD
    <!-- Open Modal Button -->
    <button @click="$dispatch('open-modal', 'add-task-modal')" class="p-3 rounded-md text-[18px] text-[#2e5e91] border border-[#2e5e91] w-full hover:bg-[#2e5e91] hover:text-white duration-200">
        Select Task List
    </button>

    <!-- Modal -->
    <x-modal name="add-task-modal">
        <!-- Content Section -->
        <div class="p-4">
            <!-- Header Section -->
            <div class="bg-[#2e5e91] rounded-md py-1 px-2 w-full">
                <h2 class="text-white text-[28px] font-medium text-center">Task List</h2>
            </div>
            <!-- Task Checklist -->
            <div class="flex flex-col gap-2 justify-end"
                x-data="{ 
                    taskList: @entangle('taskList'), 
                    selectedTaskList: @entangle('selectedTaskList'),
                    selectAll: '',
                    init() {
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
                        let s = this.selectedTaskList.length;
                        this.selectAll = s === t;
                    }
                }">

                <!-- Select All Checkbox -->
                <label class="text-sm cursor-pointer flex items-center justify-end space-x-2 mt-3 mb-3">
                    <input type="checkbox"
                        x-model="selectAll"
                        @change="selectAll ? selectAllFunction() : unselectAllFunction()"
                        class="hidden peer">

                    <div class="w-5 h-5 flex items-center justify-center border border-gray-400 rounded-full peer-checked:bg-green-500 transition-all duration-300">
                        <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                    </div>

                    <span>Select All</span>
                </label>

                <!-- Task List -->
                <template x-for="(task, id) in taskList" :key="id">
                    <label class="flex items-center space-x-2 p-2 border rounded bg-gray-100">
                        <input type="checkbox" x-model="selectedTaskList" :value="id" class="form-checkbox hidden peer" @change="selectCondition">
                        <div class="w-5 h-5 flex items-center justify-center border border-gray-400 rounded-full peer-checked:bg-green-500 transition-all duration-300">
                            <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                        </div>

                        <span x-text="task" class="text-[14px] text-black font-thin"></span>
                    </label>
                </template>
            </div>

            <!-- Confirm Button -->
            <div class="mt-4">
                <button wire:click="confirmSelection" class="button w-full ">
                    Confirm
                </button>
            </div>
        </div>
</x-modal>

=======
    @include('components.task-per-request.view')
>>>>>>> upstream/main
</div>