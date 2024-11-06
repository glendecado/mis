<form wire:submit.prevent="submitForm">
    <div class="y gap-2" x-data="{ categories: 1, others: '', category: @entangle('category')}">
        <select x-model="categories" class="input" required @change="category=categories">
            @foreach ($this->viewCategory() as $category)
                <option type="number" value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            <option value="">others</option>
        </select>

        <input x-show="categories === ''" type="text" class="input" placeholder="Type category..." x-model="category"
            required />

    </div>

</form>
