<?php

namespace App\Livewire\Request;

use App\Models\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewRequest extends Component
{
    #[On('view-request')]
    public function viewRequest($id)
    {
      $request = Request::findOrFail($id);

        if ($id != null) {
            $this->dispatch('open-modal',  'view-request-' . $id . '');
        } else {
            $this->dispatch('error', name: 'Something went wrong');
        }

        $this->dispatch('update-request');
 
    }

}
