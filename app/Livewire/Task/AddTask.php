<?php

namespace App\Livewire\Task;

use App\Events\NotifEvent;
use App\Events\RequestEventMis;
use App\Models\Request;
use App\Models\Task;
use App\Models\TechnicalStaff;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;


class AddTask extends Component
{
    

    #[On('add-task')]
    public function addTask($request_id, $tech_id)
    {
        

        $request = Request::find($request_id); 

        $nameOfAssignedInTask = TechnicalStaff::find($tech_id);//name of techstaff assigned

  

        $existingTask = Task::where('request_id', $request_id)
            ->where('technicalStaff_id', $tech_id)
            ->first(); //check if tech staff exist in this task//
                                                                    


        /////////////////////////////if task exist
        if ($existingTask) {

            if($request->status == 'pending'){

                $nameOfAssignedInTask ->totalPendingTask -= 1; //if p
                
            }
            elseif($request->status == 'ongoing'){

                $nameOfAssignedInTask->totalOngoingTask -= 1;
            }
  
            $nameOfAssignedInTask ->save();
            $existingTask->delete();
            $this->dispatch('success', name: 'successfully removed');

        } else {

            // If task does not exist, create and save it
            $task = Task::create([
                'request_id' => $request_id,
                'technicalStaff_id' => $tech_id,

            ]);
            
            ///number of notif per user
            $nameOfAssignedInTask ->totalPendingTask  += 1;
            $nameOfAssignedInTask ->save();


            //notifactions
            NotifEvent::dispatch('Request Id # ' . $request_id . ' is assigned to ' . $nameOfAssignedInTask ->user->name . 'and now pending', $request->faculty->user->id);

            //popup
            $this->dispatch('success', name: 'successfully added');

        }


        //////////////////////////////


        
        $numOfTechInTask = Task::where('request_id', $request_id)->count(); //total number of request in task

        if ($numOfTechInTask > 0) {

            $request->status = 'pending';
            $request->save();

        } else {
            $request->status = 'waiting';
            $request->save();
        }

        /////////////////////////////
        RequestEventMis::dispatch($request->faculty_id);
        RequestEventMis::dispatch($tech_id);
    }



    public function render()
    {
        return view('livewire.task.add-task');
    }
}
