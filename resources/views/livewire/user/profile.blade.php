<div>
        id: {{$user->id}}<br>
        img: {{$user->img}}<br>
        role: {{$user->role}}<br>
        name: {{$user->name}}<br>
        email: {{$user->email}}<br>
        password: {{$user->password}}<br>


        @if (Auth::id() == $user->id)
        @include('User.update')
        @endif


</div>