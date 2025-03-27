{{--task--}}


@switch($req->status)


@case('pending')
<div class="">
    <div class="w-full">
        <button class="button mt-2 float-right" style="color: white; background-color: #2e5e91; font-size: 16px;" wire:click.prevent="updateStatus('ongoing') ">Begin</button>
    </div>
</div>
@break


@case('ongoing')
<div class="">
    <p class="mb-2" style="color: #2e5e91; font-size: 16px">Task To Do</p>
    <livewire:task-per-requests/>

    <div class="">
        <div
            class="rounded-md p-2 text-white text-sm transition-all" style="background-color: #3E7B27; width: {{$req->progress}}%" ;>
            {{$req->progress}}%
        </div>
    </div>
</div>
@break


@case('resolved')



@break

@endswitch