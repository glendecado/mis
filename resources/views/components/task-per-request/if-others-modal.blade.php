

<!-- Modal Component -->
<x-modal name="add-others-task-modal" maxWidth="lg">
    <div class="p-6" x-data="{
        task: @entangle('selectedTaskList'),
        inputs: [''],
        addInput() { 
            // Only add new input if last input isn't empty
            if (this.inputs[this.inputs.length - 1].trim() !== '') {
                this.inputs.push(''); 
            }
        },
        removeInput(index) { if (this.inputs.length > 1) this.inputs.splice(index, 1); },
        saveTasks() { 
            // Filter out empty inputs before saving
            const nonEmptyInputs = this.inputs.filter(input => input.trim() !== '');
            if (nonEmptyInputs.length > 0) {
                this.task = nonEmptyInputs; 
                $wire.confirmTask(); 
                $dispatch('close-modal', 'add-task-modal');
            }
        }
    }">
        <h3 class="text-[28px] mb-2 font-medium text-[#2e5e91]">Create New Task List</h3>

        <div class="mb-4">
            <template x-for="(input, index) in inputs" :key="index">
                <div class="flex items-center space-x-3">
                    <input
                        type="text"
                        x-model="inputs[index]"
                        class="text-[16px] text-black mb-2 font-thin flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Task item"
                        @keydown.enter="addInput(); $nextTick(() => { $event.target.nextElementSibling?.nextElementSibling?.focus() })">
                    <button
                        type="button"
                        @click="removeInput(index)"
                        class="p-2 text-red-500 hover:text-red-700 rounded-full hover:bg-red-50 transition-colors"
                        :disabled="inputs.length <= 1"
                        :class="{ 'opacity-50 cursor-not-allowed': inputs.length <= 1 }">
                        <x-icons.delete />
                    </button>
                </div>
            </template>
        </div>

        <div class="flex justify-between items-center">
            <button type="button" @click="addInput()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium text-sm flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Add Another</span>
            </button>

            <button @click="saveTasks()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow transition-colors">
                Save Task List
            </button>
        </div>
    </div>
</x-modal>