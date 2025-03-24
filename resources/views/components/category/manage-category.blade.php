<div x-data="{ selectedCategoryId: null }" class="h-full p-2 table-container rounded-md"> <!-- Removed overflow-auto -->
    <div class="p-2 transition-all space-y-3"> <!-- Improved spacing between categories -->
        @foreach($this->viewCategory() as $category)
        <div :class="selectedCategoryId === {{ $category->id }} ? 'rounded-lg border-r-2 border-b-2 border-l-2 h-fit border-[#2e5e91] mt-2 rounded-b-md' : 'mt-2'">
        <div
    class="p-2 text-white cursor-pointer select-none flex justify-between items-center bg-[#2e5e91]"
    :class="selectedCategoryId === {{ $category->id }} ? 'rounded-t-md' : 'rounded-md'"
    @click="selectedCategoryId = selectedCategoryId === {{ $category->id }} ? null : {{ $category->id }}">



    <!-- Category Name -->
    <span class="flex-grow text-center text-md">{{$category->name}}</span>

    <!-- Toggle Arrow Icon -->
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
                {{-- TaskList --}}
                <livewire:task-list :category="$category->id" />

            </div>
        </div>
        @endforeach
        <div x-data="{ input: '' }" class="mt-4">
            <div class="relative w-full max-w-xs">
                <input type="text" x-model="input" class="input pr-20 p-3 w-full" style="height: 50px;" placeholder="Enter category...">
                
                <button type="button" :disabled="!input" @click="$wire.addCategory(input)" class="absolute right-0 top-0 bottom-0 px-4 text-white border-0 rounded-md m-2 z-10" style="background-color: #3E7B27;">
                    Submit
                </button>
            </div>

    </div>
</div>