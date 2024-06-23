{{--button--}}

<button type="button" @click="$dispatch('open-modal',  'example-modal')"> Add User </button>

{{--modal--}}
<x-modal name="example-modal">
    <form wire:submit.prevent="addUser">
        <label for="role">Select Role:</label>
        <select wire:model.change="role">
            <option value="Technical Staff">Technical Staff</option>
            <option value="Faculty">Faculty</option>
        </select>
        <input type="text" wire:model="name" placeholder="name">
        <input type="text" wire:model="email" placeholder="name">
        <input type="text" wire:model="password" placeholder="name">
        <input type="text" wire:model="role" placeholder="name">
    </form>
</x-modal>