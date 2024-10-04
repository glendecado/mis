@php
$i = 0;
@endphp

<ul class="text-white">
  @foreach($request->category->taskList as $tasklist)
  @if($i < $checked)
    <li>
    <input checked type="checkbox" value="{{ $i }}" wire:click="check({{ $i }})">{{ $i }} {{$tasklist->task}}
    </li>
    @elseif($i == $checked)
    <li>
      <input type="checkbox" value="{{ $i }}" wire:click="check({{ $i + 1 }})">{{ $i }} {{$tasklist->task}}
    </li>
    @else
    <li>
      <input disabled type="checkbox" value="{{ $i }}" class="bg-red-200">{{ $i }} {{$tasklist->task}}
    </li>
    @endif
    @php
    $i++;
    @endphp
    @endforeach

    <div class="h-5 bg-blue-400" style="width: {{ $request->progress }}%;">
      {{ $request->progress }}%
    </div>

    @php
    echo ''
    @endphp
</ul>