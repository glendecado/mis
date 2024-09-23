<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="user-id" content="{{ Auth::id() }}">
    <title>{{ Route::currentRouteName() }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-azure">
    @livewire('navbar')
    {{ $slot }}
</body>
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

</script>

</html>