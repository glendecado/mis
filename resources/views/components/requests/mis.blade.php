{{--task--}}
<div class="request-containder">
    @switch($req->status)

    @case('waiting')
    <div class="float-right mt-2">
        <button class="button" wire:click="updateStatus('declined')">Decline</button>
        <button class="button" wire:click="updateStatus('pending')">Accept</button>
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