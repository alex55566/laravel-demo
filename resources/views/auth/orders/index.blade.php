<x-layout>
    @section('title', 'Заказы')
    @include('navmenu.main')

    <table class="basket-table">
        <caption>
            <h3>Корзина</h3>
            <div> Оформленные заказы</div>
        </caption>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Телефон</th>
                <th scope="col">Когда отправлен</th>
                <th scope="col">Сумма</th>
                <th scope="col">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <th>{{ $order->id }}</th>
                <th>{{ $order->name }}</th>
                <th>{{ $order->phone }}</th>
                <th>{{ $order->created_at->format('H:i d/m/y') }}</th>
                <th>{{ $order->getFullPrice() }} руб. </th>
                <th><button>Подробнее</button></th>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>