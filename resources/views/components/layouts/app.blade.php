<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
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
        <div class="h-[100%] w-full overflow-auto p-5">
            {{$slot}}
        </div>
    </div>

    
    <div
        x-init="Echo.private('request-channel.{{session('user')['id']}}')
            .listen('RequestEvent', (e) => {
                $wire.$refresh();
                console.log('connected');
            });
     ">

    </div>


    @livewireScripts
</body>

</html>