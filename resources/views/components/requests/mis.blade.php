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
    <div>


        <label for="prio">Priority Level:</label>
        <select name="" id="prio" class='input' wire:change="priorityLevelUpdate($event.target.value)">
            <option value="1" @if($req->priorityLevel == 1) selected @endif>1 : High</option>
            <option value="2" @if($req->priorityLevel == 2) selected @endif>2 : Medium</option>
            <option value="3" @if($req->priorityLevel == 3) selected @endif>3 : Low</option>
        </select>


        <div class="input ">
            @include('components.task.button')
        </div>
    </div>
    @break

    @case('resolved')
    <h1>Request Resoled</h1>
    @break


    @case('declined')
    <h1>Request Declined</h1>
    @break

    @endswitch
</div>