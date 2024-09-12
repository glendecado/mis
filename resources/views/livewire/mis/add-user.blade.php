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
    <x-modal name="add-user-modal">

        <div wire:loading wire:target="role" class="w-full ">
            <div class="flex w-full justify-center items-center mb-12 rounded-md h-[500px] fixed">
                <div role="status">
                    <svg aria-hidden="true" class="inline w-10 h-10  text-gray-200 animate-spin  fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

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