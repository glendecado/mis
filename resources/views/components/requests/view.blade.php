@if (is_null($id))
    @include('components.requests.requests-table')
@else
    @include('components.requests.detailed-request')
@endif

@switch(session('user')['role'])

    @case('Faculty')
    @include('components.requests.sidebar')
    @include('components.requests.add-request-button')
    @break

@endswitch