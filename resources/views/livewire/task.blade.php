<?php

use App\Models\Task;
use App\Models\TechnicalStaff;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{computed, mount, on, state};

//
state(['id', 'task']);

on(['techs' => function(){
    $this->task = Task::where('request_id', $this->id)->get();
}]);

mount(function () {
    $this->id = session('requestId');
    $this->task = Task::where('request_id', $this->id)->get();
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
    $this->dispatch('techs');
    $this->dispatch('success', 'added');
};

$removeTask = function ($techId) {
    $task = Task::where('technicalStaff_id', $techId)->where('request_id', $this->id)->with("TechnicalStaff")->first();
    $this->dispatch('techs');
    $task->delete();
};


$viewAssigned = function () {
    
    $tech = $this->task->pluck('technicalStaff_id')->toArray();
    return $tech;
};
?>

<div>

    @include('components.task.view-task')
</div>