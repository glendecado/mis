<?php

use App\Events\RequestEvent;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Request;
use App\Models\TaskList;
use App\Models\User;
use App\Notifications\RequestStatus;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{state, mount, rules};

state(['checked', 'page',]);


state(['category', 'task', 'request']);

rules([
    'task' => 'required'
]);

mount(function () {


    $this->request = Request::find(session('requestId'));



    /* 
    if (session('page') == 'request') {
        //to get the percentage
        $this->checked = round($this->request->progress / 100 * count($this->request->category->taskList));
    } */
});

$addTaskList = function () {
    $this->validate();

    // Check if the task already exists in the same category
    $existingTask = TaskList::where('category_id', $this->category)
        ->where('task', $this->task)
        ->first();

    if ($existingTask) {
        // Dispatch a danger alert if task already exists
        $this->dispatch('danger', 'Task already exists in this category');

        return; // Exit the function if task exists
    }

    // Get the current max position in the category
    $maxPosition = TaskList::where('category_id', $this->category)->max('position');

    $position = TaskList::where('category_id', $this->category)->count() <= 0 ? 0 : $maxPosition + 1;

    // Create the new task
    $taskList = TaskList::create([
        'category_id' => $this->category,
        'task' => $this->task,
        'position' => $position,
        'status' => 'enabled',
    ]);

    $taskList->save();

    $this->reset();

    $this->category = $taskList->category_id;

    // Dispatch success message
    $this->dispatch('success', 'Task Successfully added');
};


$updateStatus = function ($id) {
    $list = TaskList::find($id);

    if ($list) {
        $list->status = ($list->status === 'enabled') ? 'disabled' : 'enabled';
        $list->save();
    }
};

$viewTaskList = function () {

    return TaskList::where('category_id', $this->category)
        ->orderBy('position') // Ensures it’s sorted by position
        ->get();
};

$check = function ($list) {

    $this->checked = $list;
    $req = Request::find($this->request->id);
    $progress = round($this->checked / count($req->category->taskList->where('status', 'enabled')) * 100);
    $req->progress = $progress;

    if ($req->progress == 100) {
        $req->status = 'resolved';
        $faculty = User::find($req->faculty_id);
        $faculty->notify(new RequestStatus($req));
    }

    $req->save();
    $this->dispatch('view-detailed-request');
    RequestEvent::dispatch($req->faculty_id);
    $this->page = 'request';
};

$updateList = function ($id, $position) {
    // Get all tasks in the current category
    $taskLists = TaskList::where('category_id', $this->category)->get();

    // Get the task to update (task1) and the task at the new position (task2)
    $task1 = TaskList::where('id', $id)->where('category_id', $this->category)->first();
    $task2 = TaskList::where('category_id', $this->category)->where('position', $position)->first();



    $newPosition = $position;
    $oldPosition = $task1->position;
    $gap = $newPosition - $oldPosition;
    $total = $taskLists->count() - 1;

    if ($gap == 1 || $gap == -1) {
        // Temporarily store task1 position
        $tempPosition = $task1->position;

        // Swap positions
        $task1->position = $task2->position;
        $task2->position = $tempPosition;

        $task1->save();
        $task2->save();
    } elseif ($gap <= 0) {

        foreach ($taskLists as $taskList) {
            if ($taskList->position >= $newPosition && $taskList->position != $total) {
                $taskList->position = $taskList->position + 1;
                $taskList->save();
            }
        }
    } elseif ($gap >= 0) {

        foreach ($taskLists as $taskList) {
            if ($taskList->position <= $newPosition && $taskList->position != 0) {
                $taskList->position = $taskList->position - 1;
                $taskList->save();
            }
        }
    }

    // Update the position of task1
    $task1->position = $newPosition;
    $task1->save();
};






?>

<div class="relative rounded-md">


    @include('components.task-list.view-task-list')


</div>