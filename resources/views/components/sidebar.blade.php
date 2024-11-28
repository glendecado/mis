<div x-cloak :class="sidebar ? 
'px-3 w-52 absolute md:relative':' w-12 relative'"
    class="h-full text-yellow pt-11 z-30 bg-blue-2"

    x-data="{ sidebar: $persist(true).using(sessionStorage)}">


    <div class="absolute top-0" @click="sidebar = !sidebar">
        <x-icons.burger />
    </div>

    {{--Request--}}
    <a wire:navigate.hover href="/request">
        <div
            class="{{request()->routeIs('request') 
    || request()->routeIs('request-table') ? 'sidebar-active' : 'sidebar-links'}}">
            Request

        </div>
    </a>


    {{--category--}}
    <a wire:navigate.hover href="/category">
        <div
            class="{{request()->routeIs('category') ? 'sidebar-active' : 'sidebar-links'}}">
            Category
        </div>
    </a>


    {{--user--}}
    <a wire:navigate.hover href="/user?roles=all">
        <div
            class="{{request()->routeIs('user') ? 'sidebar-active' : 'sidebar-links'}}">
            Users
        </div>
    </a>

</div>