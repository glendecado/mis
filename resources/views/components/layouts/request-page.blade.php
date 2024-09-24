<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>{{ Route::currentRouteName() }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="bg-azure">
  @php
  $route = Route::current()->getName();
  @endphp
  @livewire('navbar')
  <div x-data="{ open: true }" class="flex items-start">
    <div class="sticky top-0">
      <button @click="open = !open" class="p-4 bg-blue-900 text-white rounded absolute z-10">
        ☰
      </button>
    </div>


    <div
      x-show="open"
      class="bg-blue-600 w-[300px] sticky top-0 h-[100vh]"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 transform -translate-x-full"
      x-transition:enter-end="opacity-100 transform translate-x-0"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="opacity-100 transform translate-x-0"
      x-transition:leave-end="opacity-0 transform -translate-x-full">
      {{--content of sidebar--}}
      <button @click="open = !open" class="p-4 bg-blue-900 text-white rounded absolute z-10">
        ☰
      </button>




      @switch(Auth::user()->role)


      {{--if user is mis staff this is the content of the sidebar--}}
      @case('Mis Staff')
      <div class="flex flex-col mt-[50px] p-2">


        <a wire:navigate href="{{route('request')}}"
          class="{{$route == 'request' ? 'bg-yellow' : ''}}">
          view request
        </a>


        <a wire:navigate href="{{route('manage-category')}}"
          class="{{$route == 'manage-category' ? 'bg-yellow' : ''}}">
          Category
        </a>

  
      </div>

      @break




      @endswitch

    </div>

    <div class="flex-1">
      {{ $slot }}
    </div>
  </div>


</body>
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  window.currentUser = '{{base64_encode(Auth::id()) }}'
  window.currentUserType = '{{base64_encode(Auth::user()->role)}}'
</script>


</html>