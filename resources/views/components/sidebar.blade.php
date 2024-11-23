<div :class="sidebar ? 
'px-3 w-52 absolute md:relative':' w-12 relative'"
    class="h-full text-yellow pt-11 z-30 bg-blue-2"

    x-data="{
        requestClicked: false,
        userClicked: false,
        sidebar: localStorage.getItem('sidebarState') === 'true',  // Convert string to boolean
        init() {
            // Set sidebarState to true by default in localStorage when the page first loads
            if (localStorage.getItem('sidebarState') === null) {
                localStorage.setItem('sidebarState', 'true');  // Default to open (true)
            }
        },
        toggleSidebar() {
            // Toggle the sidebar state and store it in localStorage as string ('true' or 'false')
            this.sidebar = !this.sidebar;
            localStorage.setItem('sidebarState', this.sidebar.toString());
        }
    }"
    x-init="init()">

 
    <div class="absolute top-0" @click="toggleSidebar()">
        <x-icons.burger />
    </div>

    {{--Request--}}
    <div @click="requestClicked = !requestClicked; userClicked = false"
        class="{{request()->routeIs('request') 
    || request()->routeIs('request-table') ? 'sidebar-active' : 'sidebar-links'}}">
        Request

    </div>

    {{----}}
    <div x-show="requestClicked" class="w-full p-3" x-cloak>

        <a wire:navigate.hover href="/request?status=all">
            <div class="{{ request()->query('status') == 'all' ? 'sidebar-active' : 'sidebar-links' }}">
                All
            </div>
        </a>

        @if(session('user')['role'] != 'Technical Staff')
        <a wire:navigate.hover href="/request?status=waiting">
            <div class="{{ request()->query('status') == 'waiting' ? 'sidebar-active' : 'sidebar-links' }}">
                Waiting
            </div>
        </a>
        @endif

        <a wire:navigate.hover href="/request?status=pending">
            <div class="{{ request()->query('status') == 'pending' ? 'sidebar-active' : 'sidebar-links' }}">
                Pending
            </div>
        </a>

        <a wire:navigate.hover href="/request?status=resolved">
            <div class="{{ request()->query('status') == 'resolved' ? 'sidebar-active' : 'sidebar-links' }}">
                Resolved
            </div>
        </a>
    </div>
    @if(session('user')['role'] == 'Mis Staff')


    {{--category--}}
    <a wire:navigate.hover href="/category">
        <div
            class="{{request()->routeIs('category') ? 'sidebar-active' : 'sidebar-links'}}">
            Category
        </div>
    </a>


    {{--user--}}
    <div
        @click="userClicked = !userClicked; requestClicked = false"
        class="{{request()->routeIs('user') ? 'sidebar-active' : 'sidebar-links'}}">
        Users
    </div>

    {{----}}
    <div x-show="userClicked" class="w-full p-3" x-cloak>

        <a wire:navigate.hover href="/user?roles=all">
            <div class="  
            {{request()->query('roles') == 'all' ? 'sidebar-active': 'sidebar-links'}}">
                All
            </div>
        </a>


        <a wire:navigate.hover href="/user?roles=faculty">
            <div class="  
            {{request()->query('roles') == 'faculty' ? 'sidebar-active': 'sidebar-links'}}">
                Faculty
            </div>
        </a>

        <a wire:navigate.hover href="/user?roles=technicalStaff">
            <div class="  
            {{request()->query('status') == 'technicalStaff' ? 'sidebar-active': 'sidebar-links'}}">
                Technical Staff
            </div>
        </a>

    </div>
    @endif

</div>