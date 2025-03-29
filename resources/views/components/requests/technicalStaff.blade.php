{{--task--}}


@switch($req->status)


@case('pending')

    <div class="w-full flex justify-end">
        <button class="button float-right text-white bg-[#2e5e91] text-[16px]" wire:click.prevent="updateStatus('ongoing') ">Begin</button>
    </div>

@break


@case('ongoing')
<div class="">
    <livewire:task-per-requests/>

    <div class="w-full border border-[#3E7B27] rounded-md overflow-hidden">
        <div class="rounded-md p-2 text-white text-sm transition-all bg-[#3E7B27]" 
            style="width: {{ intval($req->progress) }}%;">
            {{ intval($req->progress) }}%
        </div>
    </div>
</div>
@break


@case('resolved')



@break

@endswitch

<livewire:assinged-request />