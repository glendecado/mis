  <!-- Open Modal Button -->
  <button @click="$dispatch('open-modal', 'add-task-modal')" class="button">
        Select Task List
    </button>

    <!-- Modal -->
    <x-modal name="add-task-modal">
        <div class="p-4">
            <h2 class="text-lg font-bold mb-3">Select Tasks</h2>

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


                <label class="text-sm cursor-pointer flex items-center space-x-2">
                    <input type="checkbox"
                        x-model="selectAll"
                        @change="selectAll ? selectAllFunction() : unselectAllFunction()"
                        class="hidden peer">

                    <!-- Checkbox UI -->
                    <div class="w-5 h-5 flex items-center justify-center border border-gray-400 rounded-full 
                peer-checked:bg-blue transition-all duration-300">
                        <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                    </div>

                    <span>Select all</span>
                </label>


                <template x-for="(task, id) in taskList" :key="id">
                    <label class="flex items-center space-x-2 p-2 border rounded">
                        <input type="checkbox" x-model="selectedTaskList" :value="id" class="form-checkbox hidden peer" @change="selectCondition;">
                        <!-- Checkbox UI -->
                        <div class="w-5 h-5 flex items-center justify-center border border-blue rounded-full 
                peer-checked:bg-blue transition-all duration-300">
                            <span class="text-white text-xs peer-checked:opacity-100 transition-all duration-200">✔</span>
                        </div>

                        <span x-text="task"></span>
                    </label>
                </template>
            </div>


            <!-- Confirm Button -->
            <div class="mt-4">
                <button wire:click="confirmTask" class="button-primary">
                    Confirm
                </button>
            </div>
        </div>
    </x-modal>