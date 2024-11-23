<x-modal name="add-request-modal">



    <div class="y"
        x-data="
        {
    category : @entangle('category'),
    concerns : @entangle('concerns'),
    message: ''

        }">
        @include('components.requests.confirm-location')


        <fieldset class="border p-2 rounded-md">
            <legend>Request Form</legend>
            <div class="y">
                <livewire:category wire:model="category" />
                <textarea
                    name="" id=""
                    x-model="concerns"
                    class="input mt-2"
                    placeholder="Concerns..."></textarea>

                @error('concerns')
                <span class="text-red-500"> {{$message}}</span>
                @enderror
            </div>
        </fieldset>



        <button @click="$wire.addRequest()" class="button mt-2">submit</button>
    </div>


</x-modal>