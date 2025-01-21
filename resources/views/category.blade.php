<x-layout>
    @section('title', 'Категория')
    @include('navmenu.main')
    <h2>{{ $category->name }}</h2>
    <div>Количество продуктов в категории: <b>{{$category->products->count() }}</b></div>
    <p>{{ $category->description }}</p>
    <div class="card-wrapper">
        @foreach ($category->products as $product)
        @include('card.main', compact('product'))
        @endforeach
    </div>
</x-layout>