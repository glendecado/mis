<div class="m-5 h-full p-0 md:p-4 table-container rounded-md"><!-- Added padding on both sides -->
    <h1 class="text-3xl font-bold mt-4 ml-4" style="color: #2e5e91;">Category</h1>


    <div x-data="{ selectedCategoryId: null }" class="m-3 overflow-auto h-[80vh] md:px-4" px-0> <!-- Added padding here -->

        <div class="p-0 md:p-4 transition-all space-y-3"> <!-- Improved spacing between categories -->
            @foreach($this->viewCategory() as $category)
            <div :class="selectedCategoryId === {{ $category->id }} ? 'rounded-lg border-r-2 border-b-2 border-l-2 h-fit border-blue-500 mt-2 rounded-b-m overflow-hidden text-wrap' : 'mt-2'">
                <div
                    class="p-4 text-white cursor-pointer select-none flex justify-between items-center text-ellipsis overflow-hidden"
                    style="background-color: #2e5e91;"
                    :class="selectedCategoryId === {{ $category->id }} ? 'rounded-t-md' : 'rounded-md'"
                    @click="selectedCategoryId = selectedCategoryId === {{ $category->id }} ? null : {{ $category->id }}">

                    <div class="relative flex items-center justify-center bg-white rounded-full p-2 text-ellipsis">
                        <button wire:loading.attr="disabled" class="mr-4" @click="$wire.deleteCategory({{ $category->id }})">
                            <x-icons.delete />
                        </button>
                    </div>
                    <span class="w-full text-center text-sm md:text-lg">{{$category->name}}</span>
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
      
                    <livewire:task-list :category="$category->id" />

                </div>
            </div>
            @endforeach
            <div x-data="{ input: '' }" class="mt-4 w-full">
                <div class="relative w-full">
                    <input type="text" x-model="input" class="input pr-20 p-3 w-full" style="height: 50px;" placeholder="Enter category...">

                    <button @click="$wire.addCategory(input)" class="h-10 md:h-auto relative md:absolute right-0 top-0 bottom-0 px-4 text-white border-0 rounded-md m-2 z-10" style="background-color: #3E7B27;">
                        Submit Category
                    </button>
                </div>
            </div>
        </div>
    </div>