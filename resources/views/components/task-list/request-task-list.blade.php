@php
$i = 0;
@endphp

@foreach($this->viewTaskList() as $list)
<div class="text-white">
    <div 
    class="bg-blue-300 rounded-md p-2 mb-2 cursor-pointer hover:bg-blue-200"                 
    wire:click="check({{ $i < $checked ? $i : ($i == $checked ? $i + 1 : $i) }})">
        <label class="cursor-pointer relative mr-2">
            <input
                type="checkbox"
                value="{{ $i }}"
                wire:click="check({{ $i < $checked ? $i : ($i == $checked ? $i + 1 : $i) }})"
                {{ $i < $checked ? 'checked' : ($i == $checked ? '' : 'disabled') }}
                class="{{ $i < $checked ? '' : ($i == $checked ? '' : 'bg-red-200') }} peer h-6 w-6 cursor-pointer transition-all appearance-none rounded-full bg-slate-100 shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800" id="check-custom-style" />

            <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-2 -translate-y-3">


                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>


            </span>

        </label>
        {{$list->task}}
    </div>
</div>
@php
$i++;
@endphp
@endforeach