<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="font-geist relative  h-lvh overflow-hidden z-[100]">

    {{--15%--}}
    <x-navbar />

    <div class="h-[88%] overflow-hidden flex">
        <div class="h-[100%] w-fit">
            @yield('sidebar')
        </div>
        <div class="h-[100%] w-full overflow-auto">
            @yield('content')
        </div>
    </div>

</body>

</html>
@php
session(['page' => request()->route()->getName()]);
@endphp