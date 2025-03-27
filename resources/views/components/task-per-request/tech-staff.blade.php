@foreach ($taskPerReq as $task)
<div class="border p-2 rounded-md mb-7">
    {{ $task->isCheck}}
    {{ $task->task }}
</div>
@endforeach