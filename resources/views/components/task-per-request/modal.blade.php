  <!-- Open Modal Button -->
    <button @click="$dispatch('open-modal', 'add-task-modal')" class="p-2 border border-[#2e5e91] text-[16px] text-[#2e5e91] hover:bg-[#2e5e91] duration-200 hover:text-white rounded-md w-full">
        Add Task List
    </button>

    <!-- Modal -->
    <x-modal name="add-task-modal">
        <div class="p-4">
            <!-- Task Checklist -->
            <div class="flex flex-col gap-2"
                x-data="{ 
                taskList: @entangle('taskList'), 
                selectedTaskList: @entangle('selectedTaskList') ,
                selectAll : '',
                 init() {
                // Initialize selectedTaskList with all IDs when component loads
                this.selectedTaskList = Object.keys(this.taskList).map(id => id.toString());
                this.selectAll = true;
            },
            selectAllFunction() {
                this.selectedTaskList = Object.keys(this.taskList).map(id => id.toString());
                this.selectAll = true;
            },
            unselectAllFunction() {
                    this.selectedTaskList = [];
                    this.selectAll = false;
                },
            selectCondition() {
                let t = Object.keys(this.taskList).length;
                let s = Object.keys(this.selectedTaskList).length;
                this.selectAll = s === t;
            }

            }">
                <div class="flex items-center justify-between">
                    <h2 class="text-[28px] mb-2 font-medium text-[#2e5e91]">Category Task List</h2>

                    <label class="text-sm cursor-pointer flex items-center justify-end space-x-2 mt-3 mb-3">

                        <input type="checkbox"
                            x-model="selectAll"
                            @change="selectAll ? selectAllFunction() : unselectAllFunction()"
                            class="hidden peer">

                        <div class="w-5 h-5 flex items-center justify-center border border-gray-400 rounded-full peer-checked:bg-green-500 transition-all duration-300">
                            <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                        </div>

                        <span>Select All</span>
                    </label>
                </div>

                <div class="h-[1px] w-full bg-[#2e5e91] mb-2"></div>


                <template x-for="(task, id) in taskList" :key="id">
                    <label class="flex items-center space-x-2 p-2 border rounded bg-gray-100">
                        <input type="checkbox" x-model="selectedTaskList" :value="id" class="form-checkbox hidden peer" @change="selectCondition">
                        <div class="w-5 h-5 flex items-center justify-center border border-gray-400 rounded-full peer-checked:bg-green-500 transition-all duration-300">
                            <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                        </div>

                        <span x-text="task" class="text-[14px] text-black font-thin"></span>
                    </label>
                </template>
            </div>
   

            <!-- Confirm Button -->
            <div class="mt-4">
                <button @click="$wire.confirmTask()" class="button text-[16px] w-full">
                    Confirm
                </button>
            </div>
        </div>
    </x-modal>