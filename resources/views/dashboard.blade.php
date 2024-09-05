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
        <div class="flex justify-center">
            <div class="z-0 absolute m">
                <img src="{{asset('assets/ISAT-U-logo.png') }}"  alt="" width="500" height="500">
            </div>
            <div class="z-10 p-2 ">
                <div>
                    <h1>
                        Objectives
                    </h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil, error commodi ratione est aut aliquam veniam aspernatur, esse molestias optio quaerat dignissimos quas dolore laudantium id nesciunt, ipsa ad tenetur?</p>
                </div>
                <div>
                    <h1>
                        About
                    </h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam autem consectetur et iusto beatae magnam aliquam, tenetur sed debitis cupiditate, voluptatem nulla soluta enim eveniet corrupti consequuntur similique veniam perspiciatis.
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-layouts.app>