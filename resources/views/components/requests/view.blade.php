@if (is_null($id))
@include('components.requests.requests-table')
@else
<a wire:navigate.hover href="/request?status={{session('status')}}">
    <div class="border w-fit p-2 mb-2 rounded-md px-4 bg-blue text-white">
        <x-icons.arrow direction="left" />
    </div>
</a>

@include('components.requests.detailed-request')
@endif



@if(session('user')['role'] === 'Faculty')
@include('components.requests.add-request-button')
@endif