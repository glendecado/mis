{{--task--}}
<div class="">
    @switch($req->status)

    @case('waiting')
    <div class="h-fit p-2 text-white flex justify-between items-center px-4 flex-wrap rounded-md" style="background-color: #2e5e91;">

        <div class="font-semibold" style="font-size: 14px;">
            Would you accept the request?
        </div>

        <div class="">
            <button class="bg-white p-1 rounded-md w-20" style="font-size: 14px; color: #2e5e91;" wire:click="updateStatus('pending')">Accept</button>
            <button class="border border-white p-1 rounded-md w-20" style="font-size: 14px;" wire:click="updateStatus('declined')">Decline</button>
        </div>

    </div>
    @break


    @case('pending')
    <div>

        <p style="font-size: 18px; color: #2e5e91;">Task List</p>
        <livewire:task-per-requests />

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