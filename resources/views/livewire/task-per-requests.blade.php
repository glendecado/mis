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
    @include('components.task-per-request.view')
</div>