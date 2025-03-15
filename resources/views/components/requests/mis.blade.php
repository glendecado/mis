{{--task--}}
<div class="">
    @switch($req->status)

    @case('waiting')
    <div class="h-fit p-2 text-white flex justify-between items-center px-4 flex-wrap rounded-md" style="background-color: #2e5e91;">

        <div class="text-md font-semibold">
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

        <p style="font-size: 26px; color: #2e5e91;">Task List</p>
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