@if(!empty($this->viewAssigned()))
<div class="flex flex-col y gap-2 bg-white text-black rounded-md mt-4">
    <span class="text-[16px] text-[#2e5e91]">Assigned Technical Staff</span>
    
</div>
@endif

@if(session('user')['role'] == 'Mis Staff')
@include('components.assigned-request.modal')
@endif