<div>



    {{--button to open modal--}}

    <button type="button" @click="$dispatch('open-modal',  'add-user-modal'); $dispatch('reset-validation')"> Add User </button>

    {{--modal--}}
    <x-modal name="add-user-modal">

        {{--form to be submitted at AddUser methon in misStaff class--}}
        <form wire:submit.prevent="AddUser" class="max-w-md mx-auto p-6 bg-white border rounded-lg shadow-lg">

            {{--select for a role--}}
            <label for="role">Select Role:</label>

            {{--every time the select change the network request will send an update--}}
            <select wire:model.change="role">
                <option value="Technical Staff">Technical Staff</option>
                <option value="Faculty">Faculty</option>
            </select>



            <div class="flex flex-col items-center ">



                {{--if faculty--}}
                @if ($role == 'Faculty')
                {{--foreach from array $faculty--}}
                @foreach ($faculty as $f)
                <div>
                    <label for="{{$f}}">{{$f}}:</label>
                    <input type="text" wire:model.live="{{$f}}" placeholder="{{$f}}">
                    @error($f) <span class="error">{{ $message }}</span> @enderror
                </div>
                @endforeach
                @endif




                {{--if techstaff--}}
                @if($role == 'Technical Staff')
                {{--foreach from array $techstaff--}}
                @foreach ($techStaff as $t)
                <div>
                    <label for="{{$t}}">{{$t}}:</label>
                    <input type="text" wire:model.live="{{$t}}" placeholder="{{$t}}">
                    @error($t) <span class="error">{{ $message }}</span> @enderror
                </div>
                @endforeach

                @endif

                {{--button to dispatched in data-update and to be listen at #[On('data-update')]--}}
                <button type="submit" @click="$dispatch('user-update')">add user</button>
            </div>

        </form>

    </x-modal>


</div>