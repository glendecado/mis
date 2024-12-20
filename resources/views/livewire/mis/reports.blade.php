<?php

use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{state, title};

title('Reports');

$e = function(){
    $users = Cache::remember('req', 60 * 60, function() {
        return Request::with('faculty')->get();
    });
    return $users->where('faculty_id', 2);
}

?>

<div>
@foreach($this->e() as $es)
{{$es->id}}
@endforeach
</div>
