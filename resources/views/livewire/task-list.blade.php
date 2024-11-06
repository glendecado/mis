<?php

use App\Models\Category;
use App\Models\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{state, mount};

state(['checked','page']);

state(['category', 'task','request']);

mount(function(){

    $this->request = Request::find(session('requestId'));

    //to get the percentage
    $this->checked = round($this->request->progress / 100 * count($this->request->category->taskList));

    $this->page = request()->route()->getName();

});

$addTaskList = function () {
    $taskList = TaskList::create([
        'category_id' => $this->category,
        'task' => $this->task,
    ]);
    $this->reset();

    $this->category = $taskList->category_id;
};

$deleteTaskList = function ($id) {
    $taskList = TaskList::find($id);
    $taskList->delete();
    $this->dispatch('success','sucessfully deleted');
};

$viewTaskList = function () {
    return TaskList::where('category_id', $this->category)->get();
};

$check = function($list){

    $this->checked = $list;
    $req = Request::find($this->request->id);
    $progress = round($this->checked / count($req->category->taskList) * 100);
    $req->progress = $progress ;
    $req->save();
    Cache::flush();
}
?>

<div>

    @include('components.task-list.view-task-list')


</div>