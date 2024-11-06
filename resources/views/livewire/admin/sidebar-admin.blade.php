  @section('sidebar')
      <x-sidebar>
      @section('open-items')
          <div x-data="{ ReqOpen: false, UserOpen: false }">


              <div class="relative">
                  <div class="mini-sidebar" x-show="ReqOpen">
                      <span class="mini-sidebar-label">Status</span>
                      <div class="w-full y">
                          <a wire:navigate.hover href="/admin-panel?tab=requests&status=all" class="mini-sidebar-items ">All</a>
                          <a wire:navigate.hover href="/admin-panel?tab=requests&status=waiting" class="mini-sidebar-items">Waiting</a>
                          <a wire:navigate.hover href="/admin-panel?tab=requests&status=pending" class="mini-sidebar-items">Pending</a>
                          <a wire:navigate.hover href="/admin-panel?tab=requests&status=ongoing" class="mini-sidebar-items">Ongoing</a>
                          <a wire:navigate.hover href="/admin-panel?tab=requests&status=resolved" class="mini-sidebar-items">Resolved</a>
                      </div>
                  </div>
                  <a class=" {{ $tab == 'requests' || request()->getRequestUri() == '/request/'.request()->route('id') ? 'sidebar-active' : 'sidebar-links' }}"
                      :class="ReqOpen ? 'bg-blue-400 text-white' : ''" @click="ReqOpen = !ReqOpen ; UserOpen = false">
                      Requests
                  </a>
              </div>


      

              <a wire:navigate class=" {{ $tab == 'categories' ? 'sidebar-active' : 'sidebar-links' }}"
                  href="/admin-panel?tab=categories">Request Categories</a>






              <div class="relative">
                  <div class="mini-sidebar" x-show="UserOpen">
                      <span class="mini-sidebar-label">Role</span>
                      <div class="w-full y">
                          <a wire:navigate.hover href="/admin-panel?tab=users&user=all" class="mini-sidebar-items">All</a>
                          <a wire:navigate.hover href="/admin-panel?tab=users&user=faculty" class="mini-sidebar-items">Faculty</a>
                          <a wire:navigate.hover href="/admin-panel?tab=users&user=technicalStaff" class="mini-sidebar-items">Technical Staff</a>
                      </div>
                  </div>
                  <a class=" {{ $tab == 'users' ? 'sidebar-active' : 'sidebar-links' }}"
                      @click="UserOpen = !UserOpen; ReqOpen = false" :class="UserOpen ? 'bg-blue-400 text-white' : ''">
                      Users
                  </a>
              </div>





          </div>
      @endsection

  </x-sidebar>
@endsection
