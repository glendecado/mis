{{--task--}}
<div class="request-containder">




    @if($req->progress == 100)
    <div class="gap-2">
        Share your feed back
        <livewire:feedback />
    </div>
    @else
    <div class="input">
        <div
            class="bg-blue-700 rounded-full px-2 text-white"
            style="width: {{$req->progress}}%" ;>
            {{$req->progress}}%
        </div>
    </div>
    @endif
</div>