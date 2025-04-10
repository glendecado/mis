<x-modal name="add-user-modal">
    <div class="p-4" x-data="userForm()">
        <template x-if="step === 1">
            <div class="space-y-6 text-center">
                <h1 class="text-2xl font-semibold text-[#2e5e91]">Select User Role</h1>
                <p class="text-gray-500">Choose the type of account you want to create.</p>
                <div class="grid gap-4 md:grid-cols-3">
                    <button type="button" @click="selectRole('Faculty')" class="rounded-xl border px-6 py-4 transition-all bg-white border-gray-300 hover:border-[#2e5e91] hover:bg-[#2e5e91] hover:text-white shadow-sm">
                        Faculty Staff
                    </button>
                    <button type="button" @click="selectRole('Technical Staff')" class="rounded-xl border px-6 py-4 transition-all bg-white border-gray-300 hover:border-[#2e5e91] hover:bg-[#2e5e91] hover:text-white shadow-sm">
                        Technical Staff
                    </button>
                    <button type="button" @click="selectRole('Mis Staff')" class="rounded-xl border px-6 py-4 transition-all bg-white border-gray-300 hover:border-[#2e5e91] hover:bg-[#2e5e91] hover:text-white shadow-sm">
                        MIS Staff
                    </button>
                </div>
            </div>
        </template>

        <template x-if="step === 2">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#2e5e91]">Create <span x-text="role"></span> Account</h1>
                    <button type="button" @click="step = 1" class="text-sm text-gray-500 hover:text-[#2e5e91] transition-all">&larr; Back</button>
                </div>

                <form wire:submit.prevent="addUser" class="space-y-4">
                    <!-- First Name -->
                    <div>
                        <label class="block mb-1 font-medium">First Name <span class="text-red-500">*</span></label>
                        <input type="text" class="input w-full" x-model="fname">
                        @error('fname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block mb-1 font-medium">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" class="input w-full" x-model="lname">
                        @error('lname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Faculty-only fields -->
                    <template x-if="role === 'Faculty'">
                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-1 font-medium">College <span class="text-red-500">*</span></label>
                                <select class="input w-full" x-model="college">
                                    <option value="">Select</option>
                                    <option value="CAS">CAS</option>
                                    <option value="CIT">CIT</option>
                                    <option value="COE">COE</option>
                                    <option value="CEA">CEA</option>
                                    <option value="CCI">CCI</option>
                                </select>
                                @error('college') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Building <span class="text-red-500">*</span></label>
                                <input type="text" class="input w-full" x-model="building">
                                @error('building') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Room <span class="text-red-500">*</span></label>
                                <input type="text" class="input w-full" x-model="room">
                                @error('room') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </template>

                    <!-- Email -->
                    <div>
                        <label class="block mb-1 font-medium">Email <span class="text-red-500">*</span></label>
                        <input type="email" class="input w-full" x-model="email" autocomplete="username">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }" class="relative">
                        <label class="block mb-1 font-medium">Password <span class="text-red-500">*</span></label>
                        <input :type="show ? 'text' : 'password'" class="input w-full pr-10" x-model="password" autocomplete="new-password">
                        <div class="absolute right-2 bottom-2 cursor-pointer">
                            <template x-if="show">
                                <div>
                                    <svg @click="show = !show" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" class="size-6 text-blue-950">
                                        <path
                                            d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                                        <path
                                            d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" />
                                        <path
                                            d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" />
                                    </svg>
                                </div>
                            </template>
                            <template x-if="!show">
                                <div>
                                    <svg @click="show = !show" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" class="size-6 text-blue-950">
                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </template>
                        </div>
                        @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full mt-4 py-2 bg-[#2e5e91] text-white rounded-md hover:bg-[#234a75] transition">Create User</button>
                </form>
            </div>
        </template>
    </div>




    <script>
        function userForm() {
            return {
                step: @entangle('step'),
                role: @entangle('role'),
                fname: @entangle('fname'),
                lname: @entangle('lname'),
                email: @entangle('email'),
                password: @entangle('password'),
                college: @entangle('college'),
                building: @entangle('building'),
                room: @entangle('room'),
                selectRole(selected) {
                    this.role = selected;
                    this.step = 2;
                }
            }
        }
    </script>

</x-modal>
