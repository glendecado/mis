<x-layouts.app>
    @php
    $notifications = Cache::get('notif-' . Auth::id());
    @endphp

    @if(is_countable($notifications) && count($notifications) > 0)
    <ul>
        @foreach($notifications as $id => $notification)
        <article class="text-white w-72 bg-gray-700 shadow p-4 space-y-2 rounded-md hover:-translate-y-2 duration-300 m-2">
            <p class="text-sm w-full text-gray-400">
                <li>
                    <strong>{{ $notification['message'] }}</strong><br>
                    Request ID: {{ $notification['request_id'] }}<br>
                    User ID: {{ $notification['user_id'] }}<br>
                    Timestamp: {{ $notification['timestamp']->format('Y-m-d H:i:s') }}
                </li>
            </p>

            <!-- Form for deleting notification -->
            <form action="{{ url('/deletenotif/' . $id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
            </form>
        </article>
        @endforeach
    </ul>
    @else
    <!--
        <div class="flex justify-center">
            <div class="z-0 absolute m">
                <img src="{{asset('assets/ISAT-U-logo.png') }}"  alt="" width="500" height="500">
            </div>
            <div class="z-10 p-2 ">
                <div>
                    <h1 class="font-bold">
                        Objectives
                    </h1>
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eius repudiandae dolor, tenetur recusandae excepturi eligendi voluptas perspiciatis, repellat maxime deleniti iste aperiam, quaerat pariatur ea. Obcaecati eum ut non nemo.
                    </p>
                </div>
                <br><br><br>
                <div>
                    <h1 class="font-bold">
                        Functions
                    </h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui perferendis iste commodi. Nam, ut quibusdam distinctio recusandae est eaque fuga voluptatibus corrupti consectetur totam ipsum architecto, tenetur eius ullam vitae!
                    </p>
                </div>
            </div>
            <footer class="mx-auto w-full max-w-container px-4 sm:px-6 lg:px-8 shadow-2xl">
                <div class="border-t border-slate-900/5 py-10">
                    <img src="public/ISAT-U-logo" alt="">
                        <p class="mt-5 text-center text-sm leading-6 text-slate-500">© 2025 Batch BSIT 4D. All rights reserved.</p>
                        <div class="mt-8 flex items-center justify-center space-x-4 text-sm font-semibold leading-6 text-slate-700"><a
                                href="/privacy-policy">Privacy policy</a>
                            <div class="h-4 w-px bg-slate-500/20"></div><a href="/ISAT">ISAT-University</a>
                        </div>
                 </div>
            </footer>-->
            <div class="container mx-auto max-h-auto p-10 flex md:flex-row flex-col items-center">
                <div class="bg-slate-100 p-5 rounded-2xl shadow-2xl">
                    <div>
                        <h1 class="font-bold text-primary">
                            Objectives
                        </h1>
                        <p class="text-slate-500">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eius repudiandae dolor, tenetur recusandae excepturi eligendi voluptas perspiciatis, repellat maxime deleniti iste aperiam, quaerat pariatur ea. Obcaecati eum ut non nemo.
                        </p>
                    </div>
                    <br><br><br>
                    <div>
                        <h1 class="font-bold">
                            Functions
                        </h1>
                        <p class="text-slate-500">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui perferendis iste commodi. Nam, ut quibusdam distinctio recusandae est eaque fuga voluptatibus corrupti consectetur totam ipsum architecto, tenetur eius ullam vitae!
                        </p>
                    </div>
                </div>
                <div class="mx-5">
                    <img src="{{asset('assets/ISAT-U-logo.png') }}"  alt="" width="500" height="500">
                </div>
            </div>
            <footer class="mx-auto w-full max-w-container px-4 sm:px-6 lg:px-8 shadow-2xl bg-slate-100">
                <div class="border-t border-slate-900/5 py-10">
                    <img src="public/ISAT-U-logo" alt="">
                        <p class="mt-5 text-center text-sm leading-6 text-slate-500">© 2025 Batch BSIT 4D. All rights reserved.</p>
                        <div class="mt-8 flex items-center justify-center space-x-4 text-sm font-semibold leading-6 text-slate-700"><a
                                href="/privacy-policy">Privacy policy</a>
                            <div class="h-4 w-px bg-slate-500/20"></div><a href="/ISAT">ISAT-University</a>
                        </div>
                 </div>
            </footer>
    @endif
</x-layouts.app>