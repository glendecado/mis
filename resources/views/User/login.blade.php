<div>
    <center>
        <form wire:submit.prevent="login">
            <input type="email" wire:model="email">
            <input type="password" wire:model="password">
            <button type="submit">submit</button>
        </form>
    </center>
</div>