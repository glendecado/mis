<div>

@guest
@include('User.login')
@endguest
@auth
<h1>hey</h1>
@include('User.logout')
@include('User.profile')
@include('User.update')
@endauth

</div>