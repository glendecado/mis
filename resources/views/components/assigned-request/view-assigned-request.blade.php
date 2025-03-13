@if(session('user')['role'] == 'Mis Staff')
@include('components.assigned-request.modal')
@endif


@if(!empty($this->viewAssigned()))
<div class="flex flex-col y gap-2 bg-white text-black rounded-md mt-4">
    <span style="color: #2e5e91;">Assigned Technical Staff</span>
    @foreach($this->viewTechStaff($this->viewAssigned()) as $tech)
    <div class="flex items-center gap-2 border p-2 mb-2 rounded-md relative">


        <img src="{{asset('storage/'. $tech->user->img)}}" alt=""
            class="rounded-full size-16">
        {{$tech->user->name}}


        @if(session('user')['role'] == 'Mis Staff')
        <button @click="$wire.removeTask({{$tech->user->id}})" wire:loading.attr="disabled" class="border h-full absolute right-0 flex items-center px-10 hover:bg-blue-100/50 cursor-pointer" wire:loading.class="bg-blue-100/50 cursor-progress">
            <x-icons.delete />
        </button>
        @endif
    </div>
    @endforeach
</div>
@endif