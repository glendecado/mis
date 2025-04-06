@if(!empty($this->viewAssigned()))
<div class="flex flex-col y gap-2 bg-white text-black rounded-md mt-4">
    <span class="text-[16px] text-[#2e5e91]">Assigned Technical Staff</span>
    @foreach($this->viewTechStaff($this->viewAssigned()) as $tech)
    <div class="flex items-center gap-2 border p-2 rounded-md relative flex-wrap">


        <img src="{{asset('storage/'. $tech->user->img)}}" alt=""
            class="rounded-full size-[3vw] md:size-10">

        <span class="text-[12px]">{{$tech->user->name}}</span>





        @if(session('user')['role'] == 'Mis Staff')
         @if($ifPending)

        <button @click="$wire.removeTask({{$tech->user->id}})" wire:loading.attr="disabled" class="border h-full absolute right-0 flex items-center px-10 hover:bg-blue-100/50 cursor-pointer bg-white" wire:loading.class="bg-blue-100/50 cursor-progress">
            <x-icons.delete />
        </button>
        @endif
        @endif
    </div>
    @endforeach
</div>
@endif

@if(session('user')['role'] == 'Mis Staff')
@include('components.assigned-request.modal')
@endif