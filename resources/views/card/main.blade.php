<div class='card'>
    <h3>{{ $product->name }}</h3>
    <div>Цена: {{ $product->price }} руб.</div>
    <div>Категория: {{$product->category->name}}</div>
    <form class="button-wrapper" action="{{route('basket-add', $product)}}" method="POST">
        <button type="submit" class='btn card-btn card-basket'>В корзину</button>
        <a href="{{route('product', [$product->category->code, $product->code])}}"
            class='btn card-btn card-more'>Подробнее</a>
        @csrf
    </form>
</div>