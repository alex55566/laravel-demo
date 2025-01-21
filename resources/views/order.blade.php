<x-layout>
    @include('navmenu.main')
    @section('title', 'Оформить заказ')
    <h3>Подтверидте заказ</h3>
    <div>Общая стоимость заказа: {{ $order->getFullPrice() }} руб.</div>
    <form action="{{route('basket-confirm')}}" method="POST">
        <p>Укажите свое имя и телефон для связи</p>
        <div class='form-group'>
            <label for="name">Имя:</label>
            <input type="text" name="name" id="name" value='' placeholder="Ваше имя">
        </div>
        <div class='form-group'>
            <label for="phone">Номер телефона:</label>
            <input type="text" name="phone" id="phone" value='' placeholder="Ваш телефон">
        </div>
        <button type="submit" class='btn confirm-order'>Подтвердить заказ</button></button>
        @csrf
    </form>
</x-layout>