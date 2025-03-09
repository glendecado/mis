@php
$direction = $attributes->get('direction');
@endphp

@switch($direction)
    @case('down')
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF"><path d="M480-333 240-573l51-51 189 189 189-189 51 51-240 240Z"/></svg>
        @break

    @case('up')
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF"><path d="M480-525 291-336l-51-51 240-240 240 240-51 51-189-189Z"/></svg>
        @break

    @case('left')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
        @break

    @default
        {{-- Default case if no direction is matched --}}
@endswitch
