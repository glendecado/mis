<div class="text-[20px] font-bold">
    Category
</div>

<div x-data="{ selectedCategoryId: null }" class="m-3 overflow-auto h-[80vh]">


    <div class="p-2 transition-all">
        @foreach($this->viewCategory() as $category)
        <div :class="selectedCategoryId === {{ $category->id }} ? 'rounded-lg border-r-2 border-b-2  border-l-2 h-fit border-blue-500 mt-2 rounded-b-md' : 'mt-2'">
            <div
                class="bg-blue p-2 text-white cursor-pointer select-none"
                :class="selectedCategoryId === {{ $category->id }} ? 'rounded-t-md': 'rounded-md'"
                @click="selectedCategoryId = selectedCategoryId === {{ $category->id }} ? null : {{ $category->id }}">
                {{$category->name}}
            </div>

            <div x-show="selectedCategoryId === {{ $category->id }}" class="pt-4 p-2">
                {{-- TaskList --}}
                <livewire:task-list :category="$category->id" />
            </div>
        </div>
        @endforeach
    </div>
</div>