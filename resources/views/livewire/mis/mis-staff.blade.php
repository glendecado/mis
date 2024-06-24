<div>

        @livewire('mis.add-user')
        @include('Mis.add-user')

        @include('Mis.table-user')
        <button wire:click="resetValidationErrors">Send</button>

</div>