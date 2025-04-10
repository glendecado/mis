<div class="w-full mx-auto p-6 bg-white rounded-xl shadow-md h-96 overflow-y-auto space-y-4 mb-4">
    <div class="sticky top-0 bg-white pb-4 border-b border-gray-100">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
           Feedback
        </h1>

    </div>

    @forelse($feedback as $f)

    @if($f->feedback)
    <div class="p-4 bg-gray-50 rounded-lg transition-all hover:bg-indigo-50 hover:shadow-sm border border-gray-100">
        <div class="flex items-start">
            <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-gray-700">{{ $f->feedback }}</p>

            </div>
        </div>
    </div>
    @endif
    @empty
    <div class="flex flex-col items-center justify-center h-64 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p>No feedback yet</p>
    </div>
    @endforelse
</div>



</div>