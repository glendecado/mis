{{-- Task --}}

@switch($req->status)

    @case('pending')
        <!-- Assign Tech Staff Section -->
        <livewire:assinged-request />

        <!-- "Begin" button is BELOW the assigned tech staff -->
        <div class="w-full flex justify-end mt-2">
            <button class="button float-right text-white bg-[#2e5e91] text-[16px]" 
                wire:click.prevent="updateStatus('ongoing')">
                Begin
            </button>
        </div>
    @break

    @case('ongoing')
        <!-- Task List should now be at the top -->
        <div class="">
            <livewire:task-per-requests/>

            <!-- Assign Tech Staff Section (Now Below the Task List) -->
            <livewire:assinged-request />

            <div class="w-full border border-[#3E7B27] rounded-md overflow-hidden mt-2">
                <div class="rounded-md p-2 text-white text-sm transition-all bg-[#3E7B27]" 
                    style="width: {{ intval($req->progress) }}%;">
                    {{ intval($req->progress) }}%
                </div>
            </div>
        </div>
    @break

    @case('resolved')
        <div class="p-4 border border-blue-500 rounded-md bg-gray-100 mt-2">
            <p class="text-center text-[16px] text-blue font-semibold">✅ You resolved this request.</p>
        </div>
        
        <livewire:assinged-request />
    @break

@endswitch
