<?php

use App\Events\RequestEvent;
use App\Models\AssignedRequest;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Request;
use App\Models\TaskPerRequest;
use App\Models\User;
use App\Notifications\RequestStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{mount, on, state};

state('categories', []);
state('taskList', []);
state('selectedTaskList', []);
state('taskPerReq', []);
state('notDefault', []);
state('checked', 0);
state('request', null);

on(['reqPerTask' => function () {
    $requestId = session()->get('requestId');
    $this->taskPerReq = DB::table('task_per_requests')->where('request_id', $requestId)->get();
    $this->checked = $this->taskPerReq->where('isCheck', 1)->count();
    $this->mount();
}]);

mount(function () {
    $requestId = session('requestId');

    $this->categories = DB::table('categories')
        ->where('request_id', $requestId)
        ->select('id', 'category_id', 'ifOthers', 'isDefault')
        ->get();

    $categoriesId = $this->categories->pluck('category_id')->toArray();

    $this->taskList = DB::table('task_lists')->whereIn('category_id', $categoriesId)
        ->where('status', 'enabled')
        ->pluck('task', 'id');

    $this->taskPerReq = DB::table('task_per_requests')->where('request_id', $requestId)->get();


    //meaning it is not accepted as default
    $this->notDefault = $this->categories
        ->whereNotNull('ifOthers')
        ->whereNull('isDefault')
        ->toArray();

    $this->checked = $this->taskPerReq->where('isCheck', 1)->count();
});

$confirmTask = function () {

 
    $taskList = $this->selectedTaskList;
    $requestId = session()->get('requestId');

    if (!empty($taskList)) {
        foreach ($taskList as $taskId) {

            $task = DB::table('task_lists')->where('id', $taskId)->first();

            TaskPerRequest::create([
                'request_id' => $requestId,
                'task' => $task ? $task->task : $taskId,
                'status' => 'enabled'
            ]);
        }
    }

    $this->dispatch('reqPerTask');
    $this->dispatch('view-detailed-request');
    $this->redirect('/request/'.session('requestId'), navigate:true);

};

$toDefaultCategory = function ($name, $decide) {
    $catCollection = Categories::where('ifOthers', $name)->get();

    if ($decide) {
        $defCat = Category::create(['name' => $name]);

        foreach ($catCollection as $cat) {
            $cat->update(['category_id' => $defCat->id, 'ifOthers' => null]);
        }

        $this->dispatch('success', 'Successfully saved as default; you can now set a task list for this category.');
        return redirect('/category');
    } else {

        foreach ($catCollection as $cat) {
            $cat->update(['isDefault' => 0]);
   
        }
        $this->dispatch('success', 'Successfully saved as default; you can now set a task list for this category.');
        return redirect('/request/' . session()->get('requestId'));
    }
};

$checkTask = function ($id) {
    $requestId = session('requestId');
    $taskPerReq = TaskPerRequest::find($id);

    if ($taskPerReq) {
        $taskPerReq->update(['isCheck' => !$taskPerReq->isCheck]);

        $this->taskPerReq = TaskPerRequest::where('request_id', $requestId)->get();
        $this->checked = $this->taskPerReq->where('isCheck', 1)->count();

        $this->dispatch('reqPerTask');
    }

    $this->request = Request::find($requestId);

    if ($this->request && $this->taskPerReq->count() > 0) {
        $part = $this->checked;
        $whole = $this->taskPerReq->count();
        $totalPercent = ($whole > 0) ? round(($part / $whole) * 100) : 0;


        $this->request->update([
            'progress' => $totalPercent,
            'status' => $totalPercent === 100.0 ? 'resolved' : $this->request->status
        ]);

        if ($totalPercent === 100.0) {
            $faculty = User::find($this->request->faculty_id);  // Fetch the faculty
            $faculty->notify(new RequestStatus($this->request));  // Send notification
        }
        RequestEvent::dispatch($this->request->faculty_id);
    }
   ;
   $ass = AssignedRequest::where('request_id', session('requestId'))->pluck('technicalStaff_id')->toArray();

   foreach($ass as $f){
       RequestEvent::dispatch($f);
   }

    $this->dispatch('view-detailed-request');
    Cache::forget('request_' . $requestId);
};

?>

<div>
    @if(DB::table('requests')->where('request_id', session('requestId')->first()->status === 'ongoing'))
        @script 
            <script>
                let userId = {{session('user')['id']}};
                Echo.private(`request-channel.${userId}`)
                    .listen('RequestEvent', (e) => {
                        location.reload();
                    });

                Echo.leaveChannel(`request-channel.${userId}`);
            </script>
        @endscript     
    @endif
    @include('components.task-per-request.view')
</div>
