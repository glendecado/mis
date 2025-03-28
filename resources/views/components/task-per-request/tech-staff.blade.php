@php
$i = 0; // Initialize loop counter

@endphp

<div class="flex flex-col">
    {{$checked}}
    @foreach ($taskPerReq as $list)
    <div class="flex">
        {{-- Check --}}
        @if($list->isCheck)
        <div>
            [/]
        </div>
        @else
        <div>
            []
        </div>
        @endif

        @if($list->isCheck)
        @if($i < $checked - 1)
            <div class="bg-blue-600 mt-1 rounded-md text-white text-sm w-full">
            {{$list->task}}
    </div>
    @else
    <div @click="$wire.checkTask({{$list->id}})" class="bg-blue mt-1 rounded-md text-white text-sm w-full">
        {{$list->task}}/
    </div>
    @endif
    @else
    @if($i > $checked)
    <div class="border bg-blue-600 mt-1 rounded-md text-white text-sm w-full">
        {{$list->task}}-
    </div>
    @else
    <div @click="$wire.checkTask({{$list->id}})" class="bg-blue mt-1 rounded-md text-white text-sm w-full">
        {{$list->task}}
    </div>
    @endif
    @endif

    @php
    $i++;
    @endphp
</div> {{-- Closing for .flex --}}
@endforeach
</div> {{-- Closing for .flex-col --}}