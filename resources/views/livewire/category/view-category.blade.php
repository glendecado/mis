<div class="flex flex-col">
    @foreach (\App\Models\Category::all() as $c)
    <div>
        {{$c->name}}
    </div>
    @endforeach
</div>