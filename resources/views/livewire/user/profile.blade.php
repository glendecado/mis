<!-- resources/views/profile.blade.php -->
<div class="max-w-2xl mx-auto p-6 bg-blue-400 rounded-lg shadow-md my-6">
        <div class="bg-blue p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-center mb-4">
                        <img src="{{ asset('storage/' . $user->img) }}" alt="profile" class="rounded-full w-32 h-32 object-cover shadow-lg border border-white bg-white">
                </div>
                <div class="text-center text-white">
                        <h2 class=" text-2xl font-semibold">{{ $user->name }}</h2>
                        <p class="">{{ $user->email }}</p>
                </div>
        </div>

        @if (Auth::id() == $user->id)
        <div class="text-center mt-6">
                <button type="button" @click="$dispatch('open-modal', 'Update Profile')" class="bg-blue text-white font-semibold py-2 px-6 rounded-full hover:bg-yellow hover:text-black transition duration-300 shadow-md">Change Profile</button>
        </div>
        @endif

        <div class="mt-6 space-y-4 text-lg bg-blue p-6 rounded-lg shadow-md text-white">

                <div class="flex justify-between">
                        <span class="font-geist">Role:</span>
                        <span>{{ $user->role }}</span>
                </div>
    
        </div>

        @switch(Auth::user()->role)
        @case('Faculty')
        <div class="mt-6 space-y-4 text-lg bg-blue p-6 rounded-lg shadow-md text-white">
                <div class="flex justify-between">
                        <span class="font-semibold">College:</span>
                        <span>{{ $user->faculty->college }}</span>
                </div>
                <div class="flex justify-between">
                        <span class="font-semibold">Building:</span>
                        <span>{{ $user->faculty->building }}</span>
                </div>
                <div class="flex justify-between">
                        <span class="font-semibold">Room:</span>
                        <span>{{ $user->faculty->room }}</span>
                </div>
        </div>
        @break
        @endswitch

        @livewire('User.update-profile')
</div>