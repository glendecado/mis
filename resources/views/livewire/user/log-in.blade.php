<div class="flex w-full items-center justify-center md:flex-row md:flex-wrap md:items-start md:justify-center gap-10">
    <div class="relative w-full max-w-md bg-blue-500 px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:rounded-xl sm:px-10 h-[450px] mt-[25%] md:mt-52">
        <div class="w-full">
            <div class="text-center">
                <h1 class="font-geist text-3xl font-semibold text-blue-50">Sign in</h1>
                <p class=" mt-2 text-blue-50">Sign in below to access your account</p>
            </div>
            <div class="my-[50px]">
                <form wire:submit.prevent="login" method="post">

                    <div class="relative z-0">
                        <input
                            wire:model.lazy="email" autocomplete="off"
                            type="text" id="floating_standard" class="rounded-md peer block w-full appearance-none px-5 py-3 bg-blue-100  text-sm text-gray-900  focus:outline-none focus:ring-0 {{$emailError ? 'border border-red-500':''}}" placeholder=" " />
                        <label for="floating_standard" class="absolute top-3 z-10 origin-[0] -translate-y-[35px] scale-75 transform  duration-300 peer-placeholder-shown:translate-y-0 text-lg peer-focus:start-0 peer-focus:-translate-y-[35px] peer-focus:scale-75 peer-focus:text-yellow rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 ml-2 text-gray-500">Email Address</label>

                        @if ($emailError)
                        <div class="mt-1 text-xs text-red-600 absolute">❌ {{ $emailError }}</div>
                        @endif
                    </div>

                    <div class="relative mt-9">
                        <input
                            wire:model.lazy="password" autocomplete="off"
                            type="password" id="floating_standard" class="rounded-md peer block w-full appearance-none px-5 py-3 bg-blue-100  text-sm text-gray-900  focus:outline-none focus:ring-0 {{$passwordError ? 'border border-red-500':''}}" placeholder=" " />
                        <label for="floating_standard" class="absolute top-3 z-10 origin-[0] -translate-y-[35px] scale-75 transform  duration-300 peer-placeholder-shown:translate-y-0 text-lg peer-focus:start-0 peer-focus:-translate-y-[35px] peer-focus:scale-75 peer-focus:text-yellow rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 ml-2 text-gray-500">password</label>

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