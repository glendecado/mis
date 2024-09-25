<div class="flex flex-row items-start gap-2 flex-wrap">
    {{--Livewire Component for Adding a deleting a Task List --}} <!-- Placeholder for potential future content or directives -->
    @livewire('task-list.delete-list')

    {{-- Livewire Component for Adding a Task List --}}
    @livewire('task-list.add-list')

    @foreach ($categories as $category)
    <div class="w-[300px] m-10">

        <!-- Category Name Section -->
        <div class="bg-blue-900 text-white">
            {{-- Displaying the category name --}}
            {{$category->name}}
        </div>





        <div class="bg-slate-600 h-[500px] overflow-auto">


            <!-- Task List for the Current Category -->
            @foreach ($category->TaskList as $t)
            <div class="my-2 p-2">


                {{-- Displaying individual task --}}
                @if($open == false)
                {{$loop->index + 1}}: {{$t->task}}
                @elseif($open && $openThis != $category->id )
                {{$loop->index + 1}}: {{$t->task}}
                @elseif($open && $openThis == $category->id )


                <div class="flex justify-between">
                    <div>
                        {{$loop->index + 1}}: {{$t->task}}
                    </div>
                    <div>
                        <button class="bg-red-900 text-white rounded-md p-1" @click="$dispatch('delete-task-list', {id: {{$t->id}} })">X</button>
                    </div>

                </div>

                @endif
            </div>
            @endforeach





        </div>
        <!-- Conditional Rendering Based on 'open' State -->
        @if ($open && $openThis == $category->id)


        <div x-data="{ tasks: @entangle('tasks') }" class="flex justify-between gap-1">
            {{-- Input for New Task --}}
            <input type="text" x-model="tasks" Placeholder="add task....">

            {{-- Submit Button to Add Task --}}
            <button @click="$dispatch('add-task-list', { tasks: tasks, id: {{ $category->id }} })" class="bg-green-500 w-full p-1">
                Submit
            </button>

            {{-- Cancel Button to Close Input --}}
            <button wire:click="submitInput([{{ $category->id }}, false])" class="bg-red-500 px-3 rounded-sm w-full">
                <-
            </button>
        </div>

        @elseif($open == false)
        {{-- Button to Open Task Input --}}
        <button class="w-full bg-blue-400" wire:click="submitInput([{{ $category->id }}, true])">
            Edit
        </button>

        @elseif($open && $openThis != $category->id)
        {{-- Disabled Button for Other Categories when Input is Open --}}
        <button class="w-full bg-blue-200" wire:click="submitInput([{{ $category->id }}, true])" disabled>
            Edit
        </button>
        @endif

    </div>
    @endforeach
</div>