<div class="y gap-2" x-data="{category: @entangle('category'), openSuggest: true}">
    <select  x-model="category" class="input" required>
        @foreach ($this->viewCategory() as $item) <!-- Changed variable name to $item -->
        <option type="number" value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
        <option value="" x-bind:selected="isNaN(category) || category === ''">Others</option>
    </select>

    <div class="relative" @click.outside="openSuggest = false" @keyup.enter="openSuggest = !openSuggest">

        <input @click="openSuggest = true;" x-show="isNaN(category) || category === ''" type="text" class="input w-full " placeholder="Type category..." wire:model.live="category"
            required />

        <template x-if="openSuggest">

            <div x-show="typeof category === 'string' && isNaN(category) " class="shadow-md absolute w-full bg-white rounded-md z-50 mt-1">


                @foreach($this->suggestion() as $category)

                <div class="cursor-pointer p-1 hover:bg-blue hover:text-white" @click="category = '{{$category->name}}'; openSuggest = false">
                    {{$category->name}} 
                </div>
                @endforeach

            </div>

        </template>




    </div>

</div>
