<div class="flex flex-row items-start gap-2 flex-wrap">
    {{----}} <!-- Placeholder for potential future content or directives -->

    @foreach ($categories as $category)
    <div class="w-[300px] m-10">

        <!-- Category Name Section -->
        <div class="bg-blue-900 text-white">
            {{-- Displaying the category name --}}
            {{$category->name}}
        </div>

        <div>
            <!-- Task List for the Current Category -->
            @foreach ($category->TaskList as $t)
            <div>
                {{-- Displaying individual task --}}
                {{$t->task}}
            </div>
            @endforeach

            <!-- Conditional Rendering Based on 'open' State -->
            @if ($open && $openThis == $category->id)
            {{-- Livewire Component for Adding a Task List --}}
            @livewire('task-list.add-list')

            <div>
                <div>
                    {{-- Input for New Task --}}
                    <input type="text" wire:model.live="tasks">

                    {{-- Submit Button to Add Task --}}
                    <button @click="$dispatch('add-task-list', {tasks: '{{$tasks}}', id: {{$category->id}} })">
                        Submit
                    </button>

                    {{-- Cancel Button to Close Input --}}
                    <button wire:click="submitInput([{{ $category->id }}, false])">
                        x
                    </button>
                </div>
            </div>

            @elseif($open == false)
            {{-- Button to Open Task Input --}}
            <button class="w-full bg-blue-400" wire:click="submitInput([{{ $category->id }}, true])">
                Add
            </button>

            @elseif($open && $openThis != $category->id)
            {{-- Disabled Button for Other Categories when Input is Open --}}
            <button class="w-full bg-blue-200" wire:click="submitInput([{{ $category->id }}, true])" disabled>
                Add
            </button>
            @endif
        </div>

    </div>
    @endforeach
</div>