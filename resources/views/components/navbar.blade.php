@livewire('User.log-out')
<a href="/">Home</a>
<a href="{{route('profile')}}">Profile</a>
<a href="{{route('request')}}">request</a>
@if (Auth::user()->role == 'Mis Staff')
<a href="{{route('manage-user')}}">Users</a>
@endif
<br>
<br>
<br>
<br>