<div class="bg-blue-2 px-3 w-52 h-full text-yellow absolute md:relative pt-11 z-[99]"
    x-data="{requestClicked : false, userClicked : false}">

  
    {{--Request--}}
    <div @click="requestClicked = !requestClicked" 
    class="{{request()->routeIs('request') 
    || request()->routeIs('request-table') ? 'sidebar-active' : 'sidebar-links'}}">
        Request
       
    </div>

    <div x-show="requestClicked" class="border border-yellow-400 w-full" x-cloak >
        <div @click="Livewire.navigate('/request?status=all')"
            class="sidebar-links ">
            All
        </div>
        @if(session('user')['role'] != 'Technical Staff')
        <div @click="Livewire.navigate('/request?status=waiting')" class="sidebar-links">
            Waiting
        </div>
        @endif
        <div @click="Livewire.navigate('/request?status=pending')" class="sidebar-links">
            Pending
        </div>
        <div @click="Livewire.navigate('/request?status=resolved')" class="sidebar-links">
            Resolve
        </div>
    </div>

    @if(session('user')['role'] == 'Mis Staff')


    {{--category--}}
    <div
        @click="Livewire.navigate('/category')"
        class="{{request()->routeIs('category') ? 'sidebar-active' : 'sidebar-links'}}"
        >
        Category
    </div>



    {{--user--}}
    <div 
    @click="userClicked = !userClicked"  
    class="{{request()->routeIs('user') ? 'sidebar-active' : 'sidebar-links'}}"
    >
        Users
    </div>

    <div x-show="userClicked" class="border border-yellow-400 w-full" x-cloak>

   
        <div @click="Livewire.navigate('/user?roles=all')" class="sidebar-links">
            All
        </div>

        <div @click="Livewire.navigate('/user?roles=faculty')" class="sidebar-links">
            Faculy
        </div>
        <div @click="Livewire.navigate('/user?roles=technicalStaff')" class="sidebar-links">
            Technical Staff
        </div>
    </div>
    @endif

</div>