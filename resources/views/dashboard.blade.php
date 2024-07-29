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
    <p>No notifications available.</p>
    @endif
</x-layouts.app>