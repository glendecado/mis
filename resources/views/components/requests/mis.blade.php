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
    
    @break

    @case('resolved')
    
    @break


    @case('declined')
    
    @break

    @endswitch
</div>