{{--button--}}

<button wire:click.prevent="resetValidationErrors" type="button" @click="$dispatch('open-modal',  'example-modal', )"> Add User </button>

{{--modal--}}
<x-modal name="example-modal">

    <form wire:submit.prevent="AddUser">
        <label for="role">Select Role:</label>
        <select wire:model.change="role">
            <option value="Technical Staff">Technical Staff</option>
            <option value="Faculty">Faculty</option>
        </select>
        @php
        $faculty = ['name','email', 'college', 'building','room', 'password'];
        $techStaff = ['name','email', 'password'];
        @endphp
        <div class="flex flex-col items-center ">
            @if ($role == 'Faculty')
            @foreach ($faculty as $f)
            <div>
                <label for="{{$f}}">{{$f}}:</label>
                <input type="text" wire.model.blur="{{$f}}" placeholder="{{$f}}">
                @error($f) <span class="error">{{ $message }}</span> @enderror
            </div>
            @endforeach

            @elseif($role == 'Technical Staff')
            @foreach ($techStaff as $t)
            <div>
                <label for="{{$t}}">{{$t}}:</label>
                <input type="text" wire:model.blur="{{$t}}" placeholder="{{$t}}">
                @error($t) <span class="error">{{ $message }}</span> @enderror
            </div>
            @endforeach
            @endif


            <button type="submit">add user</button>
        </div>

    </form>

</x-modal>