<div>



    {{--button to open modal--}}

    <button type="button" @click="$dispatch('open-modal',  'add-user-modal'); $dispatch('reset-validation')"> Add User </button>

    {{--modal--}}
    <x-modal name="add-user-modal">

        {{--form to be submitted at AddUser methon in misStaff class--}}
        <form wire:submit.prevent="AddUser" class="max-w-md mx-auto p-6 bg-white border rounded-lg shadow-lg">

            {{--select for a role--}}
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Select Role</label>
            {{--every time the select change the network request will send an update--}}
            <select wire:model.change="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " id="role">
                <option value="Technical Staff">Technical Staff</option>
                <option value="Faculty">Faculty</option>
            </select>



            <div class="flex flex-col ">



                {{--if faculty--}}
                @if ($role == 'Faculty')
                {{--foreach from array $faculty--}}
                @foreach ($faculty as $f)
                <div>
                    <label for="{{$f}}" class="block mb-2 text-sm font-medium text-gray-900">{{$f}}:</label>
                    <input id="{{$f}}" type="text" wire:model.blur="{{$f}}" placeholder="{{$f}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    @error($f) <span class="error text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                @endforeach
                @endif




                {{--if techstaff--}}
                @if($role == 'Technical Staff')
                {{--foreach from array $techstaff--}}
                @foreach ($techStaff as $t)
                <div>
                    <label for="{{$t}}" class="block mb-2 text-sm font-medium text-gray-900">{{$t}}:</label>
                    <input id="{{$t}}" type="text" wire:model.blur="{{$t}}" placeholder="{{$t}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    @error($t) <span class="error text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                @endforeach

                @endif
                <br>
                {{--button to dispatched in data-update and to be listen at #[On('data-update')]--}}
                <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="submit" @click="$dispatch('user-update')">add user</button>
            </div>

        </form>

    </x-modal>


</div>