<?php

namespace App\Livewire\Request;

use App\Models\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateRequest extends Component
{
    #[On('value-changed')]
    public function priority($value, $id)
    {
        $request = Request::find($id);
        $request->priorityLevel = $value;
        $request->save();
        $this->dispatch('view-request');
    }

    #[On('ongoing-request')]
    public function ongoingTask($id){
        $request = Request::find($id);
        $request->status = 'ongoing';
        $request->save();
    }


    public function render()
    {
        return view('livewire.request.update-request');
    }
}
