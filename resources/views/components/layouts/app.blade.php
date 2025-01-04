<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Request' }} | MIS Service Request Portal</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-geist relative  h-lvh overflow-hidden flex flex-col">


    <div class="h-[64px]">
        <x-header />
    </div>


    <div class="h-full overflow-hidden flex">
        @if(session('user')['role'] == 'Mis Staff')
        <div class="h-[100%] w-fit">
            <x-sidebar />
        </div>
        @endif
        <div class="h-[100%] w-full overflow-auto p-0 md:p-5">
            {{$slot}}
        </div>
    </div>

    @livewireScriptConfig

    <x-alerts />
</body>

</html>