@section('sidebar')
      <x-sidebar>
      @section('open-items')
          <div x-data="{ ReqOpen: false, UserOpen: false }">


              <div class="relative">
                  <div class="mini-sidebar" x-show="ReqOpen">
                      <span class="mini-sidebar-label">Status</span>
                      <div class="w-full y">

                          <a wire:navigate.hover href="/request?status=all" class="mini-sidebar-items ">All</a>

                          <a wire:navigate.hover href="/request?status=waiting" class="mini-sidebar-items">Waiting</a>
                          
                          <a wire:navigate.hover href="/request?status=pending" class="mini-sidebar-items">Pending</a>

                          <a wire:navigate.hover href="/request?tab=requests&status=ongoing" class="mini-sidebar-items">Ongoing</a>

                          <a wire:navigate.hover href="/request?status=resolved" class="mini-sidebar-items">Resolved</a>
                      </div>
                  </div>

                  <a class=" {{ request()->route()->uri() == 'request' || 
                  request()->route()->uri() == 'request/{id}'
                  ? 'sidebar-active' : 'sidebar-links' }}"
                      :class="ReqOpen ? 'bg-blue-400 text-white' : ''" @click="ReqOpen = !ReqOpen ; UserOpen = false">
                      Requests
                  </a>
              </div>


          </div>
      @endsection

  </x-sidebar>
@endsection
