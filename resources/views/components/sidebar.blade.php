<div x-cloak
  class="sidebar"
  :class="open ? 'w-48 md:relative absolute' : 'w-12'"
  x-data="{
        open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'), 
        toggle() {
            this.open = !this.open;
            localStorage.setItem('sidebarOpen', JSON.stringify(this.open));
        }
    }">
  <div class="w-full flex" :class="open ? 'justify-end' : 'justify-center'">
    <svg @click="toggle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-white ">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
  </div>

  <div class="y mt-5" x-show="open">
    @yield('open-items')
  </div>

  <div class="y mt-10" x-show="!open">
    @yield('closed-items')
  </div>
</div>