<?php

use App\Models\Rate;
use App\Models\Request;
use App\Models\Task;
use App\Models\TechnicalStaff;

use function Livewire\Volt\{mount, state};

//
state(['rate', 'tasks']);

mount(function () {
    $this->tasks = Task::where('request_id', session('requestId'))->with('technicalStaff')->with('rate')->get();
});

$addRate = function ($id, $FacultyRate) {


    $rate = Rate::where('task_id', $id)->first();

    if (is_null($rate)) {
        $createRate = Rate::Create([
            "task_id" => $id,
            "rate" => $FacultyRate,
        ]);
        $this->dispatch('success', 'rated successfully');
    } else {

        $rate->update(["rate" => $FacultyRate]);
        $rate->save();
        $this->dispatch('success', 'rate updated');
    }
};

$viewRate = function () {

    /*    $this->technicalStaffId = $id;
    $this->averageRating = Rating::where('technicalStaff_id', $this->technicalStaffId)->avg('rating'); */
    //$t = Task::where(technicalStaff_idm, $id)->with('rate')
    //


}
?>

<div>
    @include('components.rate.modal-rate')

</div>