@php
    $i = 0; // Initialize loop counter

@endphp

<div class="flex flex-col">
    {{ $checked }}
    @foreach ($taskPerReq as $list)
        <div class="flex">
            {{-- Check --}}

            {{--the check button--}}
            @if ($list->isCheck)
                <div>
                    [/]
                </div>
            @else
                <div>
                    []
                </div>
            @endif

            {{--if checked--}}
            @switch ($list->isCheck)

            @case(1)
                {{--disabled button--}}
                @if ($i < $checked - 1)
                    <button disabled class="bg-blue-600 mt-1 rounded-md text-white text-sm w-full">
                        {{ $list->task }}
                    </button>
                @else
                    <button type="button" @click="$wire.checkTask({{ $list->id }})"
                        class="bg-blue mt-1 rounded-md text-white text-sm w-full">
                        {{ $list->task }}
                    </button>
                @endif
            @break
            {{--for not checked--}}
            {{--if checked--}}
            
            @case(0)
                @if ($i > $checked)
                    <button disabled class="border bg-blue-600 mt-1 rounded-md text-white text-sm w-full">
                        {{ $list->task }}-
                    </button>
                @else
                    <button type="button" @click="$wire.checkTask({{ $list->id }})"
                        class="bg-blue mt-1 rounded-md text-white text-sm w-full">
                        {{ $list->task }}
                    </button>
                @endif
            @break
            @endswitch

            @php
                $i++;
            @endphp
        </div> 
    @endforeach
</div> 
