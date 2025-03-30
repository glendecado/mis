{{--task--}}
<livewire:assinged-request />

<div class="">
    @switch($req->status)

    @case('waiting')
    <div class="h-fit text-white flex justify-between items-center p-4 flex-wrap rounded-md bg-[#2e5e91]">

        <div class="font-semibold text-[16px]">
            <p>Would you accept the request?</p>
        </div>

        <div class="">
            <button class="bg-white p-1 rounded-md w-20 text-[16px] text-[#2e5e91]" wire:click="updateStatus('pending')">Accept</button>
            <button class="border border-white p-1 rounded-md w-20 text-[16px]" wire:click="updateStatus('declined')">Decline</button>
        </div>

    </div>
    @break


    @case('pending')
    @case('ongoing')    
    @case('resolved')
    
    @if($req->status == 'pending' && DB::table('task_per_requests')->where('request_id', $req->id)->count())
    @include('components.assigned-request.button')
    @endif
 
    <div>
        <p class="text-[24px] text-[#2e5e91] mb-2">Category Task List</p>
        <livewire:task-per-requests />
    </div>

    @break


    @case('declined')
        <div class="p-4 border border-red-500 rounded-md">
            <p class="text-center text-[16px] text-red-500 font-semibold">You declined this request.</p>
        </div>
    @break

    @endswitch
</div>

