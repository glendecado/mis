{{--task--}}
<div class="">
    @switch($req->status)

    @case('waiting')
    <div class="h-fit p-3 text-white flex justify-between items-center flex-wrap rounded-md" style="background-color: #2e5e91;">

        <div class="font-semibold text-[14px]">
            Would you accept the request?
        </div>

        <div class="">
            <button class="bg-white p-1 rounded-md w-20 text-[#2e5e91] text-[14px]" wire:click="updateStatus('pending')">Accept</button>
            <button class="border border-white p-1 rounded-md w-20 text-[14px]" wire:click="updateStatus('declined')">Decline</button>
        </div>

    </div>
    @break


    @case('pending')
    <div>
        <livewire:task-per-requests />
    </div>
    @break

    @case('ongoing')
    
    @break

    @case('resolved')
    
    @break


    @case('declined')
<<<<<<< HEAD
        <div class="border border-red-500 rounded-md p-4">
            <p class="text-[14px] text-red-500 text-center">You declined this request.</p>
=======
        <div>
            <p class="font-[14px] text-[#2e5e91]">You declined this request.</p>
>>>>>>> d7e3792ce14fdf8000a4bbd97f9802b2bf6ec139
        </div>
    @break

    @endswitch
</div>