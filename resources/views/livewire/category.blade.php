<?php

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{mount, state};

state('tab')->url();

state('cacheKey');

state('category')->modelable();

mount(function () {
    $this->cacheKey = 'categories_';
});

$viewCategory = function () {
    if ($this->tab == 'categories') {
        return Category::all();
    } else {
        return Cache::rememberForever($this->cacheKey . '4', function () {
            return Category::take(4)->get();
        });
    }
};

?>

<div class="basis-full">

    @include('components.category.view-category')
    <x-alerts />
</div>