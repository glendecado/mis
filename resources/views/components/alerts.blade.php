{{--https://www.penguinui.com/components/alert--}}

{{-- Successful message --}}
<div  x-cloak x-data="{ message: '', timer: null }" @success.window="
    message = $event.detail;
    clearTimeout(timer);
    timer = setTimeout(() => { message = '' }, 2000);
">
    <div x-show="message" 
         x-transition:enter="transition transform duration-300" 
         x-transition:enter-start="translate-y-full opacity-0" 
         x-transition:enter-end="translate-y-0 opacity-100" 
         x-transition:leave="transition transform duration-300" 
         x-transition:leave-start="translate-y-0 opacity-100" 
         x-transition:leave-end="translate-y-full opacity-0" 
         class="absolute w-screen bottom-10 right-0 flex-center z-50">
        <div class="relative w-96 overflow-hidden rounded-xl border border-green-600 bg-white text-slate-700 dark:bg-slate-900 dark:text-slate-300" role="alert" style="z-index: 600">
            <div class="flex w-full items-center gap-2 bg-green-600/10 p-4">
                <div class="bg-green-600/15 text-green-600 rounded-full p-1" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-green-600">Successful</h3>
                    <p class="text-xs font-medium sm:text-sm"><span x-text="message"></span></p>
                </div>
                <button class="ml-auto" aria-label="dismiss alert" @click="message = ''">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="w-4 h-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>



<div>

</div>