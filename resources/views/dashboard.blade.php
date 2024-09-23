<x-layouts.app>
    @php
    $notifications = Cache::get('notif-' . Auth::id());
    @endphp

    @if(is_countable($notifications) && count($notifications) > 0)
    <ul class="">
        @foreach($notifications as $id => $notification)
        <article class="text-white w-72 bg-gray shadow p-4 space-y-2 rounded-md hover:-translate-y-2 duration-300 m-2">
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

            <div class="container mx-auto p-10 flex flex-col md:flex-row items-center">
                <div class="bg-white p-5 rounded-2xl w-auto font-geist">
                    <div class="">
                        <h1 class="font-bold text-blue-500">
                            Objectives
                        </h1>
                        <br>
                        <p class="text-slate-500">
                            To provide the management of the University timely, and accurate information so that it can formulate rational policies, implement them on time and evaluate it.
                            <br><br>
                            It is also the objective of the MIS/EDP to provide students and faculty, access to the information highway, thereby making them aware of the latest development not only in science and technology but also in other facets of human development such as culture and politics.
                        </p>
                    </div>
                    <br><br>
                    <div>
                        <h1 class="font-bold text-blue-500">
                            Functions
                        </h1>
                        <br>
                        <p class="text-slate-500">
                            The Management Information System and Electronic Data Processing of Iloilo Science and Technology University is tasked with the development, implementation, and maintenance of the information infrastructure and information system of the College. 
                        </p>
                    </div>
                </div>
            </div>
            <footer class="mx-auto w-full max-w-container px-4 sm:px-6 lg:px-8 shadow-2xl bg-blue-900 fixed bottom-0">
                <div class="border-t border-slate-900/5 py-10">
                    <img src="public/ISAT-U-logo" alt="">
                        <p class="mt-5 text-center text-sm leading-6 text-slate-500">© BSIT 4D Batch 2025. All rights reserved.</p>
                        <div class="mt-8 flex items-center justify-center space-x-4 text-sm font-semibold leading-6 text-slate-500"><a
                                href="/privacy-policy">Privacy policy</a>
                            <div class="h-4 w-px bg-slate-500"></div><a href="/ISAT">ISAT-University</a>
                        </div>
                 </div>
            </footer>
    @endif
</x-layouts.app>