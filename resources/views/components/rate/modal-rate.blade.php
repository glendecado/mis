<x-modal name="rate">

    @foreach($technicalStaff as $techStaff)
    <div class="flex justify-between pr-24">
        {{$techStaff->user->name}}
        <div x-data="{ hovered: 0, rating: 0 }" class="flex space-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 1 || rating >= 1, 'text-gray-300': hovered < 1 && rating < 1}"
                @mouseover="hovered = 1" @mouseleave="hovered = 0" @click="rating = 1"
                wire:click="addRate({{$techStaff->user->id}},1)">

                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 2 || rating >= 2, 'text-gray-300': hovered < 2 && rating < 2}"
                @mouseover="hovered = 2" @mouseleave="hovered = 0" @click="rating = 2"
                wire:click="addRate({{$techStaff->user->id}},2)">
                >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 3 || rating >= 3, 'text-gray-300': hovered < 3 && rating < 3}"
                @mouseover="hovered = 3" @mouseleave="hovered = 0" @click="rating = 3"
                wire:click="addRate({{$techStaff->user->id}},3)">
                >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 4 || rating >= 4, 'text-gray-300': hovered < 4 && rating < 4}"
                @mouseover="hovered = 4" @mouseleave="hovered = 0" @click="rating = 4"
                wire:click="addRate({{$techStaff->user->id}},4)">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 5 || rating >= 5, 'text-gray-300': hovered < 5 && rating < 5}"
                @mouseover="hovered = 5" @mouseleave="hovered = 0" @click="rating = 5"
                wire:click="addRate({{$techStaff->user->id}},5)">
                >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    @endforeach



</x-modal>