<div>

@guest
@include('User.login')
@endguest
@auth
<h1>hey</h1>
@include('User.logout')
@endauth

</div>