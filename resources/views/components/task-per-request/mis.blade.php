@if ($taskList->isEmpty())

    @if (count($this->notDefault) > 1 || count($this->categories->toArray()) > 2)
        <p class="text-red-500">No default task</p>
        <a x-navigate href="/category" class="underline text-sm"> Proceed to this link to add default task on a
            category</a>
    @endif


    @if (count($this->notDefault) == 0 && count($this->categories->toArray()) == 1)
        <div class="p-2 border border-red-500 rounded-md">
            <p class="text-[16px] text-center text-red-500">ⓘ No task available for this category.</p>
        </div>
    @endif
@else
    @if ($taskPerReq->isEmpty())
        {{--modal--}}
        @include('components.task-per-request.modal')
    @else
        @foreach ($taskPerReq as $task)
            <div class="border p-2 rounded-md mb-2 bg-gray-100 text-[16px] font-thin">
                {{ $task->task }}
            </div>
        @endforeach
        @include('components.assigned-request.button')
    @endif


@endif

@if ($this->notDefault)
    <div class="border p-2 rounded-md mt-5">
        <p class="text-sm">there is a category that's not default,
            <span class="underline text-red-500">
                {{ implode(', ', $this->categories->whereNotNull('ifOthers')->pluck('ifOthers')->toArray()) }}
            </span>
        </p>
        <p class="text-sm">Do you want to add it as a default?</p>
        <div>
            @foreach ($this->categories->whereNotNull('ifOthers')->pluck('ifOthers')->toArray() as $name)
                <div>
                    <button @click="$wire.toDefaultCategory('{{ $name }}', true)"
                        class="border p-2 rounded-md bg-green-400 w-20 text-center">Yes</button>
                    <button @click="$wire.toDefaultCategory('{{ $name }}', false)"
                        class="border p-2 rounded-md bg-red-400 w-20 text-center">No</button>
                </div>
            @endforeach
        </div>

    </div>
@endif
