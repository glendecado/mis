<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Request' }} | MIS Service Request Portal</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-geist relative  h-svh overflow-hidden flex flex-col">



    <div class="h-[64px]" x-data="{notif : ''}">
        <x-header />
    </div>


    <div class="h-full overflow-hidden flex">
        @if(session('user')['role'] == 'Mis Staff')
        <div class="h-[100%] w-fit">
            <x-sidebar />
        </div>
        @endif
        <div class="h-[100%] w-full overflow-auto p-4 rounded-sm">

            @php
            $categoriesWithoutTasks = session('user')['role'] == 'Mis Staff'
            ? DB::table('category')
            ->leftJoin('task_lists', 'category.id', '=', 'task_lists.category_id')
            ->select('category.id', 'category.name')
            ->groupBy('category.id', 'category.name')
            ->havingRaw('COUNT(task_lists.id) = 0')
            ->get()
            : collect(); // Use an empty collection instead of an empty string
            @endphp


            @if($categoriesWithoutTasks->count() > 0 && session('user')['role'] == 'Mis Staff')
            <div
                x-data="{ show: true }"
                x-show="show"
                class="bg-amber-50 border-l-4 border-amber-400 rounded-r-lg p-4 mb-4 cursor-pointer hover:bg-amber-100 transition-colors duration-200 shadow-sm relative">
                <button @click="show = false" class="absolute top-2 right-2 text-amber-600 hover:text-amber-800 transition-colors">
                    ✖
                </button>

                <div class="flex items-start">
                    <div class="flex-shrink-0 text-amber-500 text-xl mt-0.5">
                        ⚠️
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-800 font-semibold">
                            Some default categories have no task lists! Please review them.
                        </p>

                        <div class="mt-2 text-sm text-amber-700 flex flex-wrap items-center gap-3">
                            <div class="bg-amber-100 px-2 py-1 rounded-md inline-flex items-center">
                                <span class="max-w-[200px] truncate">
                                    {{ implode(', ', $categoriesWithoutTasks->pluck('name')->toArray()) }}
                                </span>
                            </div>

                            <a wire:navigate href="/category" class="text-sm font-semibold text-amber-600 hover:text-amber-800 hover:underline underline-offset-2 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add tasks now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div x-data="{ search: '', statusDropdownOpen: ''}">
                {{$slot}}
            </div>

        </div>
    </div>

    @livewireScriptConfig

    <x-alerts />
</body>

</html>