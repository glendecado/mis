<div>
        <img src="{{asset('storage/'. $user->img)}}" alt="profile" class="rounded-[100%] w-[200px] h-[200px] object-center object-cover">
        <br>

        @if (Auth::id() == $user->id)
        <button type="button" @click="$dispatch('open-modal',  'Update Profile')"> Change Profile </button><br>
        @endif
        id: {{$user->id}}<br>
        img: {{$user->img}}<br>
        role: {{$user->role}}<br>
        name: {{$user->name}}<br>
        email: {{$user->email}}<br>
        password: {{$user->password}}<br>
        <a href="{{route('tmp')}}">delete tmp</a>
        @livewire('User.update-profile')



</div>