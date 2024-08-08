<div class="overflow-hidden">

@livewire('mis.add-user')
@livewire('mis.delete-user')

    <div class="flex flex-col p-4">
        <div class=" overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="relative  text-gray-500 focus-within:text-gray-900 mb-4">
                    <div class="absolute inset-y-0 left-1 flex items-center pl-3 pointer-events-none ">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 17.5L15.4167 15.4167M15.8333 9.16667C15.8333 5.48477 12.8486 2.5 9.16667 2.5C5.48477 2.5 2.5 5.48477 2.5 9.16667C2.5 12.8486 5.48477 15.8333 9.16667 15.8333C11.0005 15.8333 12.6614 15.0929 13.8667 13.8947C15.0814 12.6872 15.8333 11.0147 15.8333 9.16667Z" stroke="#9CA3AF" stroke-width="1.6" stroke-linecap="round" />
                            <path d="M17.5 17.5L15.4167 15.4167M15.8333 9.16667C15.8333 5.48477 12.8486 2.5 9.16667 2.5C5.48477 2.5 2.5 5.48477 2.5 9.16667C2.5 12.8486 5.48477 15.8333 9.16667 15.8333C11.0005 15.8333 12.6614 15.0929 13.8667 13.8947C15.0814 12.6872 15.8333 11.0147 15.8333 9.16667Z" stroke="black" stroke-opacity="0.2" stroke-width="1.6" stroke-linecap="round" />
                            <path d="M17.5 17.5L15.4167 15.4167M15.8333 9.16667C15.8333 5.48477 12.8486 2.5 9.16667 2.5C5.48477 2.5 2.5 5.48477 2.5 9.16667C2.5 12.8486 5.48477 15.8333 9.16667 15.8333C11.0005 15.8333 12.6614 15.0929 13.8667 13.8947C15.0814 12.6872 15.8333 11.0147 15.8333 9.16667Z" stroke="black" stroke-opacity="0.2" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </div>
                    <input type="text" id="default-search" class="block w-80 h-11 pr-5 pl-12 py-2.5 text-base font-normal shadow-xs text-gray-900 bg-slate-300 border border-blue-950 rounded-full placeholder-gray-400 focus:outline-none" placeholder="Search for ..." wire:model.live="search">
                </div>
                <div class="overflow-hidden ">
                    <table class=" min-w-full rounded-xl">
                        <thead>
                            <tr class="bg-blue-950 text-yellow-300 ">
                                <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold  capitalize "> User ID </th>
                                <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold  capitalize"> Name </th>
                                <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold  capitalize"> Email </th>
                                <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold  capitalize"> Role </th>
                                <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold  capitalize "> Actions </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300 ">
                            @foreach ($users as $user)
                            <tr class="bg-white transition-all duration-500 hover:bg-blue-100">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 ">{{$user->id}}</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 ">{{$user->name}}</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 ">{{$user->email}}</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 ">{{$user->role}}</td>
                                <td>
                                    {{--if you want to delete user--}}
                                    <button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('user-delete', { id: '{{$user->id}}' })">Delete</button>
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>