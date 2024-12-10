@if ($req->rate !== null)
    <div x-data="{ rating: {{ $req->rate }} }" class="mb-4">
        <label class="block mb-2 font-bold">Rate: {{ $req->rate }}</label>
        <div class="flex">
            <!-- Loop through 5 stars and set the rating -->
            <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer"
                    :class="{'text-yellow': star <= rating, 'text-gray-300': star > rating}"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 15.27l4.15 2.18a1 1 0 0 0 1.45-1.05l-.79-4.93 3.58-3.49a1 1 0 0 0-.55-1.71l-4.97-.72-2.22-4.5a1 1 0 0 0-1.8 0l-2.22 4.5-4.97.72a1 1 0 0 0-.55 1.71l3.58 3.49-.79 4.93a1 1 0 0 0 1.45 1.05L10 15.27z"/>
                </svg>
            </template>
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-2 font-bold">Feedback:</label>
        <p class="p-2 bg-gray-100 rounded">{{ $req->feedback }}</p>
    </div>
@endif
