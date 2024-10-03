<div class="flex w-full items-center justify-center md:flex-row md:flex-wrap md:items-start md:justify-center gap-10">
    <div class="relative w-full max-w-md bg-blue-500 px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:rounded-xl sm:px-10 h-[450px] mt-[25%] md:mt-52">
        <div class="w-full">
            <div class="text-center">
                <h1 class="font-geist text-3xl font-semibold text-blue-50">Sign in</h1>
                <p class=" mt-2 text-blue-50">Sign in below to access your account</p>
            </div>
            <div class="my-[50px]">
                <form wire:submit.prevent="login" method="post">

                    <div class="relative mt-6">
                        <input type="email" name="email" id="email" placeholder="Email Address"
                            class="peer mt-1 w-full border-b-2 border-gray-300 px-5 py-3 placeholder:text-transparent focus:border-gray-500 focus:outline-none bg-azure rounded-md"
                            wire:model.lazy="email" autocomplete="off" />

                        <label for="email"
                            class="pointer-events-none pl-3 absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-500 opacity-75 transition-all duration-100 ease-in-out {{ strlen($email) > 0 ? 'top-[-10px] left-2 pl-0 text-sm text-white' : 'peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-[-10px] peer-focus:left-2 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-white' }}">
                            Email Address
                        </label>

                        @if ($emailError)
                        <div class="mt-1 text-xs text-red-600 absolute">❌ {{ $emailError }}</div>
                        @endif
                    </div>

                    <div class="relative mt-9">
                        <input type="password" name="password" id="password" placeholder="Password"
                            class="peer mt-1 w-full border-b-2 border-gray-300 px-5 py-3 placeholder:text-transparent focus:border-gray-500 focus:outline-none bg-azure rounded-md"
                            wire:model.lazy="password" autocomplete="off" />

                        <label for="password"
                            class="pointer-events-none pl-3 absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-500 opacity-75 transition-all duration-100 ease-in-out {{ strlen($password) > 0 ? 'top-[-10px] left-2 pl-0 text-sm text-white' : 'peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-[-10px] peer-focus:left-2 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-white' }}">
                            Password
                        </label>

                        @if ($passwordError)
                        <div class="mt-1 text-xs text-red-600 absolute">❌ {{ $passwordError }}</div>
                        @endif
                    </div>


                    <div class="my-[50px]">
                        <button type="submit" class="font-geist w-full rounded-md bg-blue-200 px-3 py-4 text-white focus:bg-gray-600 focus:outline-none hover:bg-yellow hover:text-black transition duration-300">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden md:flex md:flex-col mt-52 text-blue-500">
        <h1 class="font-geist  text-8xl">MIS/EDP</h1>
        <h2 class="font-geist text-5xl">Service Request Portal</h2>
        <p class="font-sans mt-[100px] w-[500px]">A product of students from ISAT- U, for their requirements within the Bachelor of Science in Information Technology</p>
    </div>
</div>