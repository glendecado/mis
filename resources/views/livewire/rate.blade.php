<?php

use App\Models\Rate;
use App\Models\Request;
use App\Models\Task;
use App\Models\TechnicalStaff;

use function Livewire\Volt\{mount, state};

//
state(['rate', 'tasks']);

mount(function(){
    $this->tasks = Task::where('request_id', session('requestId'))->with('technicalStaff')->get();
});

$addRate = function ($id, $rate) {
    dd(['Task Id: '.$id,'Rate: '.$rate]);
};

$viewRate = function () {
  
/*    $this->technicalStaffId = $id;
    $this->averageRating = Rating::where('technicalStaff_id', $this->technicalStaffId)->avg('rating'); */
}
?>

<div>
   @include('components.rate.modal-rate')

</div>