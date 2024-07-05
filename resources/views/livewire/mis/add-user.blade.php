<div>

    {{--inputs for faculty and techstaff--}}
    @php
    $faculty = ['name','email','college','building','room','password'];
    $techStaff = ['name','email', 'password'];
    @endphp

    @include('mis.add-user')
</div>