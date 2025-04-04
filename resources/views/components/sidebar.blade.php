<!-- remove padding top -->
<div x-cloak :class="sidebar ? 'w-52 absolute md:relative px-4' : 'w-14 relative px-2'"
    class="h-full text-yellow-500 z-30 bg-blue-2 transition-all flex flex-col gap-3"
    class="h-full text-yellow-500 z-30 bg-blue-2 transition-all flex flex-col gap-3"

    x-data="{ 
        sidebar: $persist(window.innerWidth >= 700).using(sessionStorage),
        closeSidebarOnOutsideClick() { 
            if (window.innerWidth < 700) this.sidebar = false;
        }
    }"
    @click.outside="window.innerWidth < 700 ? sidebar = false : ''">
    <!-- Sidebar Toggle Button -->
    <div class="w-full flex justify-start mt-4" :class="!sidebar ? 'justify-center' : ''">
        <div class="cursor-pointer" @click="sidebar = !sidebar">
            <x-icons.burger class="size-5" />
        </div>
    </div>
    <!-- Navigation Menu -->
    <nav class="flex flex-col gap-3">
        <!-- Request -->
        <a wire:navigate.hover href="/request?status={{Cache::get('status_'.session('user')['id']) ?? 'all'}}">
            <div :class="sidebar ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-2 p-2 rounded-lg text-sm {{ request()->routeIs('request') || request()->routeIs('request-table') ? 'sidebar-active' : 'sidebar-links' }}">
                <x-icons.request class="size-5" />
                <span x-show="sidebar" class="whitespace-nowrap">REQUEST</span>
            </div>
        </a>
        <!-- Category -->
        <a wire:navigate.hover href="/category">
            <div :class="sidebar ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-2 p-2 rounded-lg text-sm {{ request()->routeIs('category') ? 'sidebar-active' : 'sidebar-links' }}">
                <x-icons.category class="size-5" />
                <span x-show="sidebar" class="whitespace-nowrap">CATEGORY</span>
            </div>
        </a>
        <!-- Users -->
        <a wire:navigate.hover href="/user?roles=all">
            <div :class="sidebar ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-2 p-2 rounded-lg text-sm {{ request()->routeIs('user') ? 'sidebar-active' : 'sidebar-links' }}">
                <x-icons.user class="size-5" />
                <span x-show="sidebar" class="whitespace-nowrap">USERS</span>
            </div>
        </a>
        <!-- Reports -->
        <a wire:navigate.hover href="/reports">
            <div :class="sidebar ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-2 p-2 rounded-lg text-sm {{ request()->routeIs('reports') ? 'sidebar-active' : 'sidebar-links' }}">
                <x-icons.reports class="size-5" />
                <span x-show="sidebar" class="whitespace-nowrap">REPORTS</span>
            </div>
        </a>
    </nav>
</div>
