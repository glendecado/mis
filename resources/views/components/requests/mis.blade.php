{{--task--}}
<div class="">
    @switch($req->status)

    @case('waiting')
    <div class="bg-blue h-fit p-3 text-white flex justify-between items-center px-4 flex-wrap rounded-md">

        <div class="text-lg">
            Would you accept the request?
        </div>

        <div class="">
            <button class="bg-white text-blue-500 p-2 rounded-md w-24" wire:click="updateStatus('pending')">Accept</button>
            <button class="border border-white p-2 rounded-md w-24" wire:click="updateStatus('declined')">Decline</button>
        </div>

    </div>
    @break


    @case('pending')
    <div>

        Task List
        <livewire:task-list :category="$req->category_id" />

    </div>
    @break

    @case('ongoing')
    <h1>Request Ongoing</h1>
    @break

    @case('resolved')
    <h1>Request Resoled</h1>
    @break


    @case('declined')
    <h1>Request Declined</h1>
    @break

    @endswitch
</div>