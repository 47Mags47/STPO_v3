<x-mail::message>
<style>
    /* Прячем ячейку таблицы с футером */
    .footer {
        display: none !important;
        visibility: hidden !important;
        mso-hide: all !important;
        font-size: 0 !important;
        line-height: 0 !important;
    }
</style>

# Здравствуйте, {{ $name }}! 🚀

Добро пожаловать в **СТПО**. Мы рады, что вы с нами!

Чтобы начать работу и получить доступ ко всем модулям системы, пожалуйста, подтвердите ваш адрес электронной почты, нажав на кнопку ниже:

<x-mail::button :url="$url" color="success">
Подтвердить аккаунт
</x-mail::button>

<x-mail::panel>
Если кнопка выше не работает, скопируйте и вставьте эту ссылку в браузер:
<a href="{{ $url }}" style="color: rgb(48, 169, 209); text-decoration: underline;">
    {{ $url }}
</a>
</x-mail::panel>

С уважением,<br>
Команда **{{ config('app.name') }}**
</x-mail::message>
