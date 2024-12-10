<div x-cloak :class="sidebar ? 
'px-3 w-52 absolute md:relative':' w-12 relative'"
    class="h-full text-yellow pt-11 z-30 bg-blue-2 transition-all"

    x-data="{ sidebar: $persist(true).using(sessionStorage)}">


    <div class="absolute top-0 right-2" @click="sidebar = !sidebar">
        <x-icons.burger />
    </div>


    {{--Request--}}
    <a wire:navigate.hover href="/request?status={{Cache::get('status_'.session('user')['id']) ?? 'all'}}">
        <div
            :class="sidebar ? 'justify-start': 'justify-center'"
            class="{{request()->routeIs('request') 
    || request()->routeIs('request-table') ? 'sidebar-active' : 'sidebar-links'}}">
            <x-icons.request class="size-5" />
            <span x-show="sidebar">Request</span>
        </div>
    </a>


    {{--category--}}
    <a wire:navigate.hover href="/category">
        <div
            :class="sidebar ? 'justify-start': 'justify-center'"
            class="{{request()->routeIs('category') ? 'sidebar-active' : 'sidebar-links'}}
                
            ">
            <x-icons.category class="size-5" />
            <span x-show="sidebar">Category</span>
        </div>
    </a>


    {{--user--}}
    <a wire:navigate.hover href="/user?roles=all">
        <div
            :class="sidebar ? 'justify-start': 'justify-center'"
            class="{{request()->routeIs('user') ? 'sidebar-active' : 'sidebar-links'}}">
            <x-icons.user class="size-5" />
            <span x-show="sidebar">Users</span>
        </div>
    </a>

</div>