@if ($req->rate !== null)
<div class="p-6 rounded-md bg-gradient-to-br from-[#2e5e91]/10 to-[#2e5e91]/5 border border-[#2e5e91]/20 shadow-sm mt-4">
    <!-- Rating Section -->
    <div x-data="{ rating: {{ $req->rate }} }" class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="flex items-center bg-[#2e5e91]/10 px-3 py-1 rounded-full border border-[#2e5e91]/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="ml-1 font-medium text-[#2e5e91]" x-text="rating"></span>
            </div>
            <h3 class="text-lg font-medium text-[#2e5e91]">Rating</h3>
        </div>
        
        <div class="flex gap-1">
            <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7"
                    :class="{
                        'text-amber-400': star <= rating,
                        'text-gray-200': star > rating
                    }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </template>
        </div>
    </div>

    <!-- Feedback Section -->
    <div>
        <div class="flex items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2e5e91]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <h3 class="text-lg font-medium text-[#2e5e91]">Feedback</h3>
        </div>
        <div class="p-4 bg-white rounded-lg border border-[#2e5e91]/20">
            <p class="text-gray-700 leading-relaxed text-sm">{{ $req->feedback }}</p>
        </div>
    </div>
</div>
@endif