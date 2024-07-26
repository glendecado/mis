<div>



    {{--button to open modal--}}

    <div class="group">

        <button class="fixed right-10 bottom-8 p-0 text-6xl type=" button" @click="$dispatch('open-modal',  'add-user-modal')">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;">
                <rect width="24" height="24" rx="12" fill="#172554" />
                <path d="M12 5V19" stroke="#fde047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5 12H19" stroke="#fde047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        {{--when hover this will show--}}
        <div class="invisible group-hover:visible fixed right-24 bottom-10 shadow-xl w-[100px] h-10 text-center text-blue-950 border rounded-md">
            <p>Add user</p>
        </div>
    </div>



    {{--modal--}}
    <x-modal name="add-user-modal">

        {{--form to be submitted at AddUser methon in misStaff class--}}
        <form wire:submit.prevent="AddUser">

            {{--select for a role--}}
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Select Role</label>
            {{--every time the select change the network request will send an update--}}
            <select wire:model.change="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-5" id="role">
                <option value="Technical Staff">Technical Staff</option>
                <option value="Faculty">Faculty</option>
            </select>



            <div class="flex flex-col ">



                {{--if faculty--}}
                @if ($role == 'Faculty')
                {{--foreach from array $faculty--}}
                @foreach ($faculty as $f)
                <div class="mb-2">
                    <label for="{{$f}}" class="block mb-2 text-sm font-medium text-gray-900">{{$f}}:</label>
                    <input id="{{$f}}" type="text" wire:model.blur="{{$f}}" placeholder="{{$f}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error($f) <span class="error text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                @endforeach
                @endif




                {{--if techstaff--}}
                @if($role == 'Technical Staff')
                {{--foreach from array $techstaff--}}
                @foreach ($techStaff as $t)
                <div class="mb-5">
                    <label for="{{$t}}" class="block mb-2 text-sm font-medium text-gray-900">{{$t}}:</label>
                    <input id="{{$t}}" type="text" wire:model.blur="{{$t}}" placeholder="{{$t}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error($t) <span class="error text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                @endforeach

                @endif
                <br>
                {{--button to dispatched in data-update and to be listen at #[On('data-update')]--}}
                <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="submit">add user</button>
            </div>

        </form>

    </x-modal>


</div>