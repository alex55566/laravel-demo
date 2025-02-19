<div class="navmenu">
    <div>
        <a href={{ route('index') }}>Главная</a>
        <a href={{ route('categories') }}>Категории</a>
        <a href={{ route('basket') }}>Корзина</a>
    </div>

    <div>
        @guest
        <a href={{ route('register') }}>Зарегистрироваться</a>
        <a href={{ route('login') }}>Войти</a>
        @endguest
        @auth
        <a href={{ route('get-logout') }}>Выйти</a>
        @endauth
    </div>
</div>
