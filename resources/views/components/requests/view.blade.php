

@if (is_null($id))
    @include('components.requests.requests-table')
@else
    <a wire:navigate href="/">
        <div class="border w-fit p-2 mb-2 rounded-md px-4 bg-blue text-white">
            <x-icons.arrow direction="left" />
        </div>
    </a>

    @include('components.requests.detailed-request')
@endif

@switch(session('user')['role'])

    @case('Faculty')
    @include('components.requests.add-request-button')
    @break


@endswitch