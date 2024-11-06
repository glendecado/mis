@php
$i = 0;
@endphp

@foreach($this->viewTaskList() as $list)
    <div class="text-white">
        <div class="bg-blue-300 rounded-md p-2 mb-2">
            @if($i < $checked)
                <input checked type="checkbox" value="{{ $i }}" wire:click="check({{ $i }})"> {{ $i }} {{$list->task}}
            @elseif($i == $checked)
                <input type="checkbox" value="{{ $i }}" wire:click="check({{ $i + 1 }})"> {{ $i }} {{$list->task}}
            @else
                <input disabled type="checkbox" value="{{ $i }}" class="bg-red-200"> {{ $i }} {{$list->task}}
            @endif
        </div>
    </div>
    @php
        $i++;
    @endphp
@endforeach
