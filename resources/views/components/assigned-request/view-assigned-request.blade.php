@if(session('user')['role'] == 'Mis Staff')
@include('components.assigned-request.modal')
@endif


@if(!empty($this->viewAssigned()))
<div class="flex flex-col y gap-2 bg-white text-black rounded-md mt-4">
    <span style="color: #2e5e91; font-size: 18px;">Assigned Technical Staff</span>
    @foreach($this->viewTechStaff($this->viewAssigned()) as $tech)
    <div class="flex items-center gap-2 border p-2 mb-2 rounded-md relative flex-wrap" style="font-size: 16px;">

        <div class="flex items-center gap-2">
            <img src="{{asset('storage/'. $tech->user->img)}}" alt=""
                class="rounded-full size-[3vw] md:size-16">

            <span class="md:text-lg text-[3vw]">{{$tech->user->name}}</span>
        </div>




        @if(session('user')['role'] == 'Mis Staff')
        <button @click="$wire.removeTask({{$tech->user->id}})" wire:loading.attr="disabled" class="border h-full absolute right-0 flex items-center px-10 hover:bg-blue-100/50 cursor-pointer bg-white" wire:loading.class="bg-blue-100/50 cursor-progress">
            <x-icons.delete />
        </button>
        @endif
    </div>
    @endforeach
</div>
@endif