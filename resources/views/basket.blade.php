<x-layout>
    @section('title', 'Корзина')
    @include('navmenu.main')
    @include('info-alert')

    @if (!$order)
    <div class="empty-basket">Корзина пуста</div>
    @else
    <table class="basket-table">
        <caption>
            <h3>Корзина</h3>
            <div> Оформление заказа</div>
        </caption>
        <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Кол-во</th>
                <th scope="col">Цена</th>
                <th scope="col">Стоимость</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->products as $product)
            <tr>
                <th>{{ $product->name }}</th>
                <th class="quantity-wrapper">
                    {{$product->pivot->count}}
                    <form class="product-remove form" action="{{route('basket-remove', $product)}}" method="POST">
                        <button type="submit">-</button>
                        @csrf
                    </form>
                    <form class="product-add form" action="{{route('basket-add', $product)}}" method="POST">
                        <button type="submit">+</button>
                        @csrf
                    </form>
                </th>
                <th>{{ $product->price }} руб.</th>
                <th>{{ $product->getPriceForCount() }} руб.</th>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th scope="row" colspan="2"> Общая стоимость:</th>
                <th colspan="2">
                    <strong>{{ $order->getFullPrice() }} руб.</strong>
                </th>
            </tr>
        </tfoot>
    </table>
    <div class="confirm-wrapper">
        <a class="btn confirm-order" href="{{route('basket-place')}}">Оформить заказ</a>
    </div>
    @endif
</x-layout>