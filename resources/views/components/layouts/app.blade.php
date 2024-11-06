<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="font-geist relative bg-azure h-lvh overflow-hidden">

    <div class="h-[15%]">
        <x-navbar />
    </div>

    <div class="h-[85%] overflow-hidden flex">
        <div class="h-[100%] w-fit">
            @yield('sidebar')
        </div>
        <div class="h-[100%] w-full overflow-auto">
            {{$slot}}
        </div>
    </div>

</body>

</html>
@php
session(['page' => request()->route()->getName()]);
@endphp