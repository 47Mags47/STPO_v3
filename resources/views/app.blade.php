<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/sass/app.sass')
    @vite('resources/css/main.css')
    @vite('resources/js/app.js')

    @inertiaHead
    @routes
</head>

<body class="bg-(--background-color)">

    @inertia

</body>

</html>
