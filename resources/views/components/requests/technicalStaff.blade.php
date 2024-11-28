{{--task--}}

@switch($req->status)


@case('pending')
<div class="request-containder">
    <div class="w-full">
        <button class="button float-right" wire:click.prevent="updateStatus('ongoing') ">Begin</button>
    </div>
</div>
@break


@case('ongoing')
<div class="request-containder">
    <livewire:task-list :category="$req->category_id" />
    <div class="input">
        <div
            class="bg-blue-700 rounded-full px-2 text-white transition-all"
            style="width: {{$req->progress}}%" ;>
            {{$req->progress}}%
        </div>
    </div>
</div>
@break


@case('resolved')

<div class="gap-2 request-containder">
    Feedback
    <livewire:feedback />
</div>

@break

@endswitch