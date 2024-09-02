@php
//class design for input
$input = 'rounded bg-slate-200 border border-slate-900 m-2 p-2';
@endphp
<div>
    <x-modal name="update">

        {{--check if user exist--}}
        @if (isset($user))
        <form wire:submit.prevent="updateUser" class="flex flex-col">
            <label for="name">name</label>
            <input type="text" name="name" id="" placeholder="{{$user->name}}" class="{{$input}}" wire:model="name">
            <input type="text" name="email" id="" placeholder="{{$user->email}}" class="{{$input}}" wire:model="email">
            <select wire:model.change="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-5" id="role">

                <option value="{{$user->role}}">{{$user->role}}</option>
                @if ($user->role == "Technical Staff")
                <option value="Faculty">Faculty</option>
                @else
                <option value="Technical Staff">Technical Staff</option>
                @endif
            </select>
            <input type="text" name="password" id="" class="{{$input}}" wire:model="password">
            <button type="submit">Confirm</button>
        </form>
        @endif


    </x-modal>
</div>