<div>
    {{--button to open modal--}}


    <div class="group">
        <button class="fixed right-10 bottom-8 p-0 text-6xl" type="button" @click="$dispatch('open-modal',  'add-request-modal'); $dispatch('reset-validation')">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;">
                <rect width="24" height="24" rx="12" fill="#3b82f6" />
                <path d="M12 5V19" stroke="#fde047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5 12H19" stroke="#fde047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        {{--when hover this will show--}}
        <div class="invisible group-hover:visible fixed right-24 bottom-10 shadow-xl p-5 text-center text-blue-950 border rounded-md bg-white">
            <p>Add Request</p>
        </div>
    </div>

    {{--modal--}}
    <x-modal name="add-request-modal">

        <div>
            <form wire:submit.prevent="addRequest">
                <div class="mb-5">
                    <div x-data="{ category: @entangle('category'), others: @entangle('others')};">
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                        <select id="s" x-model="category" x-show="category == 'Computer/laptop/printer' && " class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-5">
                            <option value="Computer/laptop/printer">Computer/laptop/printer</option>
                            <option value="Network">Network</option>
                            <option value="Software">Software</option>
                            <option value="Telephone">Telephone</option>
                            <option value="Others">Others</option>
                        </select>

                        <template x-if="category === 'Others'">
                            <textarea id="concerns" x-model="others" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                        </template>
                    </div>
                    @error('category') <span class="error text-xs text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="concerns" class="block mb-2 text-sm font-medium text-gray-900">Concern</label>
                    <textarea id="concerns" wire:model.blur="concerns" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " data-gramm="false"> </textarea>
                    @error('concerns') <span class="error text-xs text-red-600">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mt-5">Submit</button>
            </form>
        </div>

    </x-modal>
</div>