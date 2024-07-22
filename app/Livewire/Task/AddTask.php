<?php

namespace App\Livewire\Task;

use App\Events\RequestEventMis;
use App\Models\Request;
use App\Models\Task;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;


class AddTask extends Component
{
    #[On('add-task')]
    public function addTask($request_id, $tech_id)
    {
        $mis = User::where('role', 'Mis Staff')->first();
        // Check if the task already exists
        $existingTask = Task::where('request_id', $request_id)
            ->where('technicalStaff_id', $tech_id)
            ->first();

        if ($existingTask) {
            // If task exists, delete it
            $existingTask->delete();


        } else {
            // If task does not exist, create and save it
            $task = Task::create([
                'request_id' => $request_id,
                'technicalStaff_id' => $tech_id,
            ]);  

        }

        $request = Request::find($request_id);

        $total = Task::where('request_id', $request_id)->count();

        if ($total > 0) {
            $request->status = 'pending';
            $request->save();
        }else{
            $request->status = 'waiting';
            $request->save();
        }
      /*   
        $request = Request::find($request_id);

        $request->status = 'pending';
        $total = Task::where('request_id', $request_id)->count();

        if($total < 1){
            $request->status = 'pending';
            $request->save();
        } */

    }



    public function render()
    {
        return view('livewire.task.add-task');
    }
}
