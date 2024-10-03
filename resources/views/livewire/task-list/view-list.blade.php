<div>
    <ul>
        {{$category}}
        @if($category->tasklist && $category->tasklist->isNotEmpty())
        @foreach ($category->tasklist as $tasklist)
        <li>{{ $tasklist->task }}</li>
        @endforeach
        @else
        <li>No tasks for this category.</li>
        @endif
    </ul>
</div>