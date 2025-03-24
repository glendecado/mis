<?php

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{mount, state, title};

title('Category');

state('tab')->url();

state('cacheKey');

state(['category_' => []])->modelable();


mount(function () {
    if (request()->route()->getName() == 'category') {
        session(['page' => 'category']);
    }
    $this->cacheKey = 'categories_';

});


$viewCategory = function () {
    if (request()->route()->getName() == 'category') {
        return Category::all();
    } else {
        return Cache::rememberForever($this->cacheKey . '4', function () {
            return Category::get();
        });
    }
};



$addCategory = function ($category) {
    if (empty($category)) {
        $this->dispatch('error', 'No input');
        return;
    }

    $existingCategory = Category::where('name', ucfirst(strtolower($category)))->first();

    if (!$existingCategory) {
        $create = Category::create([
            "name" => ucfirst(strtolower($category))
        ]);
        $create->save();
        $this->dispatch('success', 'New Category successfully created.');
    } else {
        $this->dispatch('danger', 'Category already exists.');
    }

    $this->redirect('/category', navigate: true);
};



?>


<div class="basis-full">

    @include('components.category.view-category')

</div>