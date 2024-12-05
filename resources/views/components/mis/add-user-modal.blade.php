<x-modal name="add-user-modal">
    <form wire:submit.prevent="addUser">
        <div class='y gap-2' x-data="{
            role: @entangle('role'),
            fname: @entangle('fname'),
            lname: @entangle('lname'),
            email: @entangle('email'),
            password: @entangle('password'),
            college: @entangle('college'),
            building: @entangle('building'),
            room: @entangle('room')
        }">

            {{-- Role --}}
            <div class="y">
                <label for="role" class="label">Role:</label>
                <select name="role" id="role" class="input" x-model="role">
                    <option value="Technical Staff">Technical Staff</option>
                    <option value="Faculty">Faculty</option>
                </select>
                @error('role') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- First Name and Last Name --}}
            <div class='md:x y gap-2'>
                <div class='y basis-1/2'>
                    <label for="fname" class="label">First Name:</label>
                    <input type="text" id="fname" class="input" x-model="fname">
                    @error('fname') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class='y basis-1/2'>
                    <label for="lname" class="label">Last Name:</label>
                    <input type="text" id="lname" class="input" x-model="lname">
                    @error('lname') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Faculty-Specific Fields --}}
            <div class='md:x y gap-2' x-show="role == 'Faculty'">
                <div class='y'>
                    <label for="college" class="label">College:</label>
                    <select type="text" id="college" class="input w-full" x-model="college">
                        <option value="CAS">CAS</option>
                        <option value="CIT">CIT</option>
                        <option value="COE">COE</option>
                        <option value="CEA">CEA</option>
                    </select>
                    @error('college') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class='y'>
                    <label for="building" class="label">Building:</label>
                    <input type="text" id="building" class="input w-full" x-model="building">
                    @error('building') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class='y'>
                    <label for="room" class="label">Room:</label>
                    <input type="text" id="room" class="input w-full" x-model="room">
                    @error('room') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="y gap-2">
                <label for="email" class="label">Email:</label>
                <input type="text" id="email" class="input" x-model="email">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div class="y relative" x-data="{ show: false }">
                <label for="password" class="label">Password:</label>
                <input :type="show ? 'text' : 'password'" id="password" class="input" x-model="password">
                <svg @click="show = !show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6 absolute top-8 right-3">
                    <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    <path x-show="show" stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path x-show="show" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />

                </svg>
                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="button">Add User</button>
        </div>
    </form>




</x-modal>