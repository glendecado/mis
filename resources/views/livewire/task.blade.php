<?php

use App\Models\Task;
use App\Models\TechnicalStaff;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{computed, mount, state};

//
state(['id']);

mount(function () {
    $this->id = session('requestId');
});


$viewTechStaff = computed(function ($arr = null) {
    if (is_null($arr)) {
        return Cache::flexible('tech',[5,10], function(){
            return TechnicalStaff::with(['user', 'task'])->get();
        });
    } else {
        return TechnicalStaff::whereIn('technicalStaff_id', $arr)->with(['user', 'task'])->get();
    }
});

$assignTask = function ($techId) {

    $task = Task::create([
        'technicalStaff_id' => $techId,
        'request_id' => session('requestId')
    ]);
    $task->save();
    $this->dispatch('success', 'added');
};

$removeTask = function ($techId) {
    $task = Task::where('technicalStaff_id', $techId)->where('request_id', $this->id)->with("TechnicalStaff")->first();

    $task->delete();
};


$viewAssigned = function () {
    $task = Task::where('request_id', $this->id);
    $tech = $task->pluck('technicalStaff_id')->toArray();
    return $tech;
};
?>

<div>

    @include('components.task.view-task')
</div>