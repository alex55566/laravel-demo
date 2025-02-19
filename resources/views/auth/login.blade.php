<x-layout>
    @section('title', 'Авторизация')
    <form action="{{ route('login') }}" method="POST">
        <h3>Авторизация</h3>
        <label for="email">E-Mail</label>
        <input type="email" name="email" placeholder="E-Mail">
        <label for="password">Пароль</label>
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit">Войти</button>
        @csrf
    </form>
</x-layout>