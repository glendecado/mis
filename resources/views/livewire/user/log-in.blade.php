<div class="flex w-full h-max items-center justify-center md:flex-row md:flex-wrap md:items-start md:justify-center gap-10">
    <div>
        @error('email') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="relative w-full max-w-md bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:rounded-xl sm:px-10 h-[450px] mt-52">
        <div class="w-full">
            <div class="text-center">
                <h1 class="text-3xl font-semibold text-gray-900">Sign in</h1>
                <p class="mt-2 text-gray-500">Sign in below to access your account</p>
            </div>
            <div class="my-[50px]">
                <form wire:submit.prevent="login" method="post">
                    <div class="relative mt-6">
                        <input type="email" name="email" id="email" placeholder="Email Address" class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" autocomplete="NA" wire:model.blur="email" />
                        <label for="email" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Email Address</label>
                        @if ($emailError)
                        <div class="mt-1 text-xs text-red-600 absolute">❌ {{ $emailError }}</div>
                        @endif
                    </div>
                    <div class="relative mt-9">
                        <input type="password" name="password" id="password" placeholder="Password" class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" wire:model.blur="password" />
                        <label for="password" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Password</label>
                        @if ($passwordError)
                        <div class="mt-1 text-xs text-red-600 absolute">❌ {{ $passwordError }}</div>
                        @endif
                    </div>

                    <div class="my-[50px]">
                        <button type="submit" class="w-full rounded-md bg-blue-900 px-3 py-4 text-white focus:bg-gray-600 focus:outline-none">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="hidden md:flex md:flex-col mt-52 text-blue-950">
        <h1 class="text-8xl">MIS/EDP</h1>
        <h2 class="text-5xl">Service Request System</h2>
        <p class="mt-[100px] w-[500px]">A product of students from ISAT- U, for their requirements within the Bachelor of Science in Information Teachnology</p>

    </div>

</div>