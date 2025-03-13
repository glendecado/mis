<div class="group">
    <button

        x-data="{
category : @entangle('category'),
concern : @entangle('concerns')
}"

        @click=" 
 $dispatch('open-modal', 'add-request-modal'); 
 category = 1;
 concern = '';

 ">
        <div
            class="modal-trigger-button" style="border-color: #2e5e91;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12" style="color: #2e5e91;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>


        </div>
    </button>

    @include('components.requests.add-request-modal')


    <div class="tooltip" style="color: #2e5e91;">
        Create Request
    </div>
</div>