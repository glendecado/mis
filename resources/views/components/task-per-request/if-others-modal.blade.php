<!-- Primary Action Button -->
<button @click="$dispatch('open-modal', 'add-task-modal')" class="p-2 border border-[#2e5e91] text-[16px] text-[#2e5e91] hover:bg-[#2e5e91] duration-200 hover:text-white rounded-md w-full">
    Add Task List For This Request
</button>

<!-- Modal Component -->
<x-modal name="add-task-modal" maxWidth="lg">
    <div class="p-6" x-data="{
        task: @entangle('selectedTaskList'),
        inputs: [''],
        addInput() { this.inputs.push(''); },
        removeInput(index) { if (this.inputs.length > 1) this.inputs.splice(index, 1); },
        saveTasks() { this.task = this.inputs; $wire.confirmTask(); $dispatch('close-modal', 'add-task-modal'); }
    }">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Create New Task List</h3>

        <div class="space-y-4 mb-6">
            <template x-for="(input, index) in inputs" :key="index">
                <div class="flex items-center space-x-3">
                    <input
                        type="text"
                        x-model="inputs[index]"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Task item"
                        @keydown.enter="addInput(); $nextTick(() => { $event.target.nextElementSibling?.nextElementSibling?.focus() })">
                    <button
                        type="button"
                        @click="removeInput(index)"
                        class="p-2 text-red-500 hover:text-red-700 rounded-full hover:bg-red-50 transition-colors"
                        :disabled="inputs.length <= 1"
                        :class="{ 'opacity-50 cursor-not-allowed': inputs.length <= 1 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
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