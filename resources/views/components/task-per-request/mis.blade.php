<<<<<<< HEAD
@if (count($this->notDefault) > 0 && $this->taskList->isEmpty())
<p class="p-2 border border-red-500 text-red-500 text-[16px] text-center rounded-md">ⓘ No default task.</p>
<!-- <a x-navigate href="/category" class="underline text-sm"> Proceed to this link to add default task on a
    category</a> -->
=======



@if ($taskPerReq->isEmpty())

@if (count($this->notDefault) === 0 && $this->taskList->isEmpty())
<p class="text-red-500">No default task</p>
<a x-navigate href="/category" class="underline text-sm"> Proceed to this link to add default task on a
    category</a>
>>>>>>> upstream
@endif


@if (count($this->notDefault) > 0 && count($this->categories->toArray()) < 1)
<div class="p-2 border border-red-500 rounded-md">
    <p class="text-[16px] text-center text-red-500">ⓘ No task available for this category.</p>
</div>

@include('components.task-per-request.if-others-modal')
@elseif(!$taskList->isEmpty())
{{-- modal --}}
@include('components.task-per-request.modal')
@endif
@else
@foreach ($taskPerReq as $task)
<div class="border p-2 rounded-md mb-2 bg-gray-100 text-[16px] font-thin">
    {{ $task->task }}
</div>
@endforeach

@endif

@if ($this->notDefault)
<div class="border p-2 sm:p-4 rounded-md bg-gray-100 mt-5 w-full max-w-full">
    <p class="text-sm sm:text-base">There is a category named
        <span class="underline text-red-500 break-words">
            {{ implode(', ', $this->categories->whereNotNull('ifOthers')->pluck('ifOthers')->toArray()) }}
        </span>
        that is not set as default.
    </p>
    <p class="text-sm sm:text-base">Do you want to add it as a default category?</p>
    <div class="mt-3 space-y-2 flex justify-end">
        @foreach ($this->categories->whereNotNull('ifOthers')->pluck('ifOthers')->toArray() as $name)
        <div class="flex flex-wrap gap-2">
            <button @click="$wire.toDefaultCategory('{{ $name }}', true)"
                class="border p-2 rounded-md bg-green-400 w-20 text-center text-white text-sm sm:text-base hover:bg-green-500 transition-colors">Yes</button>
            <button @click="$wire.toDefaultCategory('{{ $name }}', false)"
                class="border p-2 rounded-md bg-red-400 w-20 text-center text-white text-sm sm:text-base hover:bg-red-500 transition-colors">No</button>
        </div>
        @endforeach
    </div>
</div>
@endif