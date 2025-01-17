<x-layout>
    <div>Категория</div>
    <h2>
        @if($category == 'mobiles')
        Мобильные телефоны
        @elseif ($category == 'portable')
        Портативная техника
        @elseif ($category == 'appliances')
        Бытовая техника
        @endif
    </h2>
</x-layout>