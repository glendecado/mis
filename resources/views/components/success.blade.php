@if(session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="absolute bottom-0 right-0 mb-4 mr-4 p-4 bg-green-500 text-white rounded-md shadow-md">
    {{ session('success') }}
</div>
@endif