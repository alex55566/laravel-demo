<x-layout>
    @section('title', 'Категории')
    @include('navmenu.main')
    @foreach ($categories as $category)
    <div class='category'>
        <a class='category-link' href={{ route('category', $category->code) }}>{{ $category->name }}</a>
        <p class='category-desc'>{{ $category->description }}</p>
    </div>
    @endforeach
</x-layout>