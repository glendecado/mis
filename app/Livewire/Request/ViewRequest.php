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

    }

}
