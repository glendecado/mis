@php
$i = 0;
@endphp

@foreach($this->viewTaskList() as $list)
<div class="text-white">

    {{--if check--}}
    @if($i < $checked)

        <div class="bg-blue-300 rounded-md p-2 mb-2 flex cursor-pointer" wire:click="check({{ $i }})">
        <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-blue-500 mr-2">
            <circle cx="12" cy="12" r="10" />
            <path d="M9 12l2 2 4-4" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <!-- Loader -->
        <svg wire:loading xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            class="animate-spin size-6 text-blue-500">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        {{$list->task}}
</div>

{{--below checked--}}
@elseif($i == $checked)

<div class="group cursor-pointer" wire:click="check({{ $i + 1 }})">
    <div class="bg-blue-300 rounded-md p-2 mb-2 flex items-center">
        <div class="relative">
            <!-- Default State -->
            <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="size-6 group-hover:text-blue-900 transition-colors duration-200">
                <circle cx="12" cy="12" r="10" />
                <path d="M9 12l2 2 4-4"
                    class="group-hover:opacity-100 opacity-0 transition-opacity duration-200 bg-blue-300"
                    fill="none" stroke="#60A5FA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <!-- Loader -->
            <svg wire:loading xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                class="animate-spin size-6 text-blue-500">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </div>
        <span class="ml-2 text-white">{{$list->task}}</span>
    </div>
</div>

{{--disabled--}}
@else
<div class="bg-blue-300 rounded-md p-2 mb-2">
    {{$list->task}}
</div>
@endif

</div>

{{--increment i every loop--}}
@php
$i++;
@endphp


@endforeach