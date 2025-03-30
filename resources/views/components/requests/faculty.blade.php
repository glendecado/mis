@if($req->status == 'declined')
    <h1 class="text-red-500 text-[16px] text-center border border-red-500 p-2 rounded-md">
        ⓘ Request Declined.
    </h1>
@elseif($req->status == 'waiting')
    <h1 class="text-red-500 text-[16px] text-center border border-red-500 p-2 rounded-md">
        ⓘ Waiting for your request to be accepted.
    </h1>
@else
    <p class="mb-2 text-blue text-[16px]">Task Progress</p>

    <div class="rounded-md bg-gray-100">
        <div class="rounded-md p-2 text-white text-sm bg-[#3E7B27]" style="width: {{$req->progress}}%;">
            {{$req->progress}}%
        </div>
    </div>

    <livewire:assinged-request />

    @if($req->progress == 100 && $req->rate == null)
        @include('components.requests.button-rate')
    @endif
@endif
