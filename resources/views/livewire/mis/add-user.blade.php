<div>



    {{--button to open modal--}}

    <div class="group">

        <button class="fixed right-10 bottom-8 p-0 text-6xl" type="button" @click="$dispatch('open-modal',  'add-user-modal'); $dispatch('reset-validation')">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;">
                <rect width="24" height="24" rx="12" fill="#172554" />
                <path d="M12 5V19" stroke="#fde047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5 12H19" stroke="#fde047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        {{--when hover this will show--}}
        <div class="invisible group-hover:visible fixed right-24 bottom-10 shadow-xl p-5 text-center text-blue-950 border rounded-md">
            <p>Add user</p>
        </div>
    </div>



    {{--modal--}}
    <x-modal name="add-user-modal" maxWidth="fit">


        {{--form to be submitted at AddUser methon in misStaff class--}}
        <form wire:submit.prevent="AddUser" class="w-[500px]">

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

                    @if ($f == 'college')
                    <label for="{{$f}}" class="block mb-2 text-sm font-medium text-gray-900">{{$f}}:</label>
                    <select wire:model.blur="{{$f}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-5" id="{{$f}}">
                        <option value="CAS">CAS</option>
                        <option value="CEA">CEA</option>
                        <option value="COE">COE</option>
                        <option value="CIT">CIT</option>
                    </select>

                    @else

                    <label for="{{$f}}" class="block mb-2 text-sm font-medium text-gray-900">{{$f}}:</label>
                    <div x-data="{ show: false }">
                        @if ($f == 'password')
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="{{$f}}" wire:model.blur="{{$f}}" placeholder="{{$f}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                <svg :class="{'hidden': show, 'block': !show }" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M19.071 19.071A9.453 9.453 0 0112 21a9.453 9.453 0 01-7.071-2.929m0-14.142A9.453 9.453 0 0112 3a9.453 9.453 0 017.071 2.929M9.878 9.878a3 3 0 104.244 4.244M15 12h.01"></path>
                                </svg>
                                <svg :class="{'block': show, 'hidden': !show }" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.056 10.056 0 0112 19.5c-5.246 0-9.5-4.254-9.5-9.5S6.754.5 12 .5s9.5 4.254 9.5 9.5a10.056 10.056 0 01-.375 2.825M19.071 19.071A9.453 9.453 0 0112 21a9.453 9.453 0 01-7.071-2.929m0-14.142A9.453 9.453 0 0112 3a9.453 9.453 0 017.071 2.929M9.878 9.878a3 3 0 104.244 4.244M15 12h.01"></path>
                                </svg>
                            </button>
                        </div>
                        @else
                        <input id="{{$f}}" type="text" wire:model.blur="{{$f}}" placeholder="{{$f}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @endif
                    </div>


                    @error($f)
                    <span class="error text-xs text-red-600">{{ $message }}</span> @enderror
                    @endif

                </div>
                @endforeach
                @endif




                {{--if techstaff--}}
                @if($role == 'Technical Staff')
                {{--foreach from array $techstaff--}}
                @foreach ($techStaff as $t)
                <div class="mb-5">
                    <label for="{{$t}}" class="block mb-2 text-sm font-medium text-gray-900">{{$t}}:</label>
                    <div x-data="{ show: false }">
                        @if ($t == 'password')
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="{{$t}}" wire:model.blur="{{$t}}" placeholder="{{$t}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                <svg :class="{'hidden': show, 'block': !show }" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M19.071 19.071A9.453 9.453 0 0112 21a9.453 9.453 0 01-7.071-2.929m0-14.142A9.453 9.453 0 0112 3a9.453 9.453 0 017.071 2.929M9.878 9.878a3 3 0 104.244 4.244M15 12h.01"></path>
                                </svg>
                                <svg :class="{'block': show, 'hidden': !show }" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.056 10.056 0 0112 19.5c-5.246 0-9.5-4.254-9.5-9.5S6.754.5 12 .5s9.5 4.254 9.5 9.5a10.056 10.056 0 01-.375 2.825M19.071 19.071A9.453 9.453 0 0112 21a9.453 9.453 0 01-7.071-2.929m0-14.142A9.453 9.453 0 0112 3a9.453 9.453 0 017.071 2.929M9.878 9.878a3 3 0 104.244 4.244M15 12h.01"></path>
                                </svg>
                            </button>
                        </div>
                        @else
                        <input id="{{$t}}" type="text" wire:model.blur="{{$t}}" placeholder="{{$t}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @endif
                    </div>
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