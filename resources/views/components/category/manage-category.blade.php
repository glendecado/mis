<div class="px-4"> <!-- Added padding on both sides -->
    <h1 class="text-[20px] font-bold text-blue">Category</h1>
</div>

<div x-data="{ selectedCategoryId: null }" class="m-3 overflow-auto h-[80vh] px-4"> <!-- Added padding here -->

    <div class="p-2 transition-all space-y-2"> <!-- Improved spacing between categories -->
        @foreach($this->viewCategory() as $category)
        <div :class="selectedCategoryId === {{ $category->id }} ? 'rounded-lg border-r-2 border-b-2 border-l-2 h-fit border-blue-500 mt-2 rounded-b-md' : 'mt-2'">
            <div
                class="bg-blue p-2 text-white cursor-pointer select-none flex justify-between items-center"
                :class="selectedCategoryId === {{ $category->id }} ? 'rounded-t-md': 'rounded-md'"
                @click="selectedCategoryId = selectedCategoryId === {{ $category->id }} ? null : {{ $category->id }}">
                <span>{{$category->name}}</span>
                <span x-show="selectedCategoryId !== {{ $category->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF">
                        <path d="M480-333 240-573l51-51 189 189 189-189 51 51-240 240Z" />
                    </svg>
                </span>
                <span x-show="selectedCategoryId === {{ $category->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF">
                        <path d="M480-525 291-336l-51-51 240-240 240 240-51 51-189-189Z" />
                    </svg>

                </span>
            </div>
            <div x-show="selectedCategoryId === {{ $category->id }}" class="pt-4 p-2 relative">
                <button wire:loading.attr="disabled" class="absolute right-2" @click="$wire.deleteCategory({{$category->id}})"><x-icons.delete /></button>
                <p class="-translate-y-3 text-sm text-blue/80">"Drag and drop to rearrange the list items."</p>
                {{-- TaskList --}}
                <livewire:task-list :category="$category->id" />
            </div>
        </div>
        @endforeach

        <div x-data="{ input: '' }">
            <input type="text" x-model="input" class="input">
            <button @click="$wire.addCategory(input)" class="button">Add Category</button>
        </div>


    </div>
</div>