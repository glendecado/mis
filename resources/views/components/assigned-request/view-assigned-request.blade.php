@if(session('user')['role'] == 'Mis Staff')
@include('components.assigned-request.modal')
@endif


@if(!empty($this->viewAssigned()))
<div class="flex flex-col request-containder">
    Assinged Technical Staff
    @foreach($this->viewTechStaff($this->viewAssigned()) as $tech)
    <div class="flex items-center gap-2 border p-2 mb-2 rounded-md relative">


        <img src="{{asset('storage/'. $tech->user->img)}}" alt=""
            class="rounded-full size-16">
        {{$tech->user->name}}


        @if(session('user')['role'] == 'Mis Staff')
        <div disabled class="border h-full absolute right-0 flex items-center px-2 cursor-pointer" wire:click.prevent="removeTask('{{$tech->user->id}}')">
            remove
        </div>
        @endif
    </div>
    @endforeach
</div>
@endif