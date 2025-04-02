
    <div class="group flex flex-col items-center modal-trigger-button">
        <button x-data="{ category: @entangle('category'), concern: @entangle('concerns') }"
            @click="$dispatch('open-modal', 'add-request-modal'); category = 1; concern = '';"
            class="p-2 rounded-full border-2 border-[#2e5e91] hover:bg-[#2e5e91] hover:text-white transition">
            <div class="flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-[#2e5e91] group-hover:text-white transition">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
        </button>

        @include('components.requests.add-request-modal')

        <div class="tooltip text-[#2e5e91] w-auto whitespace-nowrap">
            Create Request
        </div>
    </div>
