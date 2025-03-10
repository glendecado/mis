<?php

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{mount, state, title};

title('Category');

state('tab')->url();

state('cacheKey');

state('category')->modelable();

state('categories');

state('suggestion');

mount(function () {
    if (request()->route()->getName() == 'category') {
        session(['page' => 'category']);
    }
    $this->cacheKey = 'categories_';

    $this->categories = 1;
});

$viewCategory = function () {
    if (request()->route()->getName() == 'category') {
        return Category::all();
    } else {
        return Cache::rememberForever($this->cacheKey . '4', function () {
            return Category::take(4)->get();
        });
    }
};

$suggestion = function() {
    // If no category is provided, retrieve all categories (or modify the logic as needed)
    if(empty($this->category)) {
        return Category::take(0)->get();  // Optionally, you can adjust this to return all categories if necessary
    } else {
        return Category::where('name', 'LIKE', '%'.$this->category.'%')->take(4)->get();
    }
};

$addCategory = function ($category) {
    $create = Category::create([
        "name" => ucfirst(strtolower($category))
    ]);
    $create->save();
    $this->dispatch('success', 'New Category successfully created.');
    $this->redirect('/category', navigate: true);
};

$deleteCategory = function($id) {
    $category = Category::find($id);
    $category->delete();
    $this->dispatch('success', 'New Category successfully deleted.');
    $this->redirect('/category', navigate: true);

};

?>


<div class="basis-full">

    @include('components.category.view-category')

</div>