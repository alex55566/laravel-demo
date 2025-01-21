<x-layout>
    @include('navmenu.main')
    <div class="card-wrapper">
        @foreach ($products as $product)
        @include('card.main', compact('product'))
        @endforeach
    </div>
</x-layout>