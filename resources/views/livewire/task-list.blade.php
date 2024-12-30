<?php

use App\Events\RequestEvent;
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


    if (session('page') == 'request') {
        //to get the percentage
        $this->checked = round($this->request->progress / 100 * count($this->request->category->taskList));
    }
});

$addTaskList = function () {
    $this->validate();

    // Get the current max position in the category
    $maxPosition = TaskList::where('category_id', $this->category)->max('position') ?? 0;

    $position = ++$maxPosition;

    $taskList = TaskList::create([
        'category_id' => $this->category,
        'task' => $this->task,
        'position' => $position,
    ]);

    $taskList->save();

    $this->reset();

    $this->category = $taskList->category_id;
};


$deleteTaskList = function ($id) {
    $this->dispatch('success', 'sucessfully deleted');
    $taskList = TaskList::find($id);
    $taskList->delete();
};

$viewTaskList = function () {
    return TaskList::where('category_id', $this->category)
        ->orderBy('position') // Ensures it’s sorted by position
        ->get();
};

$check = function ($list) {

    $this->checked = $list;
    $req = Request::find($this->request->id);
    $progress = round($this->checked / count($req->category->taskList) * 100);
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
    $taskLists = TaskList::where('category_id', $this->category)->get();

    // Loop through all tasks in the category and update their positions
    foreach ($taskLists as $taskList) {
        if ($taskList->position >= $position) {
            // Shift tasks with equal or greater position by +1
            $taskList->position = $taskList->position + 1;
            $taskList->save();
        }
    }

    // Update the position of the task that is being moved
    $taskListToUpdate = TaskList::find($id);
    if ($taskListToUpdate) {
        $taskListToUpdate->position = $position;
        $taskListToUpdate->save();
    }
};





?>

<div class="relative rounded-md">

    
    @include('components.task-list.view-task-list')


</div>