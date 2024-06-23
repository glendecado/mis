@php
$black_background = 'h-[100vh] w-[100%] bg-gray-900/50 fixed top-0 left-0 flex items-center justify-center';
$card = 'h-auto w-auto bg-white rounded';
$x = 'float-right m-2 text-3xl';
@endphp


{{-- open = false --}}
<div x-data="{ open: false }">
    {{-- modal button --}}
    {{--modal when click--}}
    {{--get the id modal then toggle it to hidden--}}
    {{--then change the value of open to !open meaning false--}}
    <button x-on:click="$refs.modal.classList.toggle('hidden'); open = ! open" class="{{$class ?? ''}}">{{$name}}</button>
    {{-- first modal is hidden --}}
    <div id="modal" x-ref="modal" class="hidden">
        {{-- if open is equals to true then show if false then hide --}}
        <div x-show="open" class="{{$black_background}}">
            <div @click.outside="$refs.modal.classList.toggle('hidden'); open = ! open">
                <div x-show="open" x-transition.duration.500ms class="{{$card}}">
                    <button @click="$refs.modal.classList.toggle('hidden'); open = ! open" class="{{$x}}">x</button>
                    {{----}}
                    <div class="p-[50px] {{$cardStyle ?? ' '}}">
                        {{$slot}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>