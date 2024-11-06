<?php

use App\Models\Rate;
use App\Models\Request;
use App\Models\Task;
use App\Models\TechnicalStaff;

use function Livewire\Volt\{mount, state};

//
state(['rate', 'technicalStaff']);

mount(function(){
    $task = Task::where('request_id', session('requestId'))->get();

    $tech = $task->pluck('technicalStaff_id')->toArray();

    $this->technicalStaff = TechnicalStaff::whereIn('technicalStaff_id', $tech)->with('user')->get();
    
});

$addRate = function ($id, $rate) {
    dd([$id,$rate]);
};

$viewRate = function () {
  
/*    $this->technicalStaffId = $id;
    $this->averageRating = Rating::where('technicalStaff_id', $this->technicalStaffId)->avg('rating'); */
}
?>

<div>
   @include('components.rate.modal-rate')

</div>