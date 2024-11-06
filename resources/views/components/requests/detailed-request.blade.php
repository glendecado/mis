
@foreach($this->viewDetailedRequest() as $req)

<div>
    @switch(session('user')['role'])
        @case('Mis Staff')
            @include('components.requests.mis')
        @break
        @case('Faculty')
            @include('components.requests.faculty')
        @break
        @case('Technical Staff')
            @include('components.requests.technicalStaff')
        @break
    @endswitch
</div>

@endforeach