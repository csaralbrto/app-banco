<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')

    <title>{{config('app.name','App Banco')}}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->

</head>

<body class="text-center p-20 md:p-20 lg:p-40">

    <img src="{{ asset('images/bank.png') }}" class="inline" alt="App banco" />

    <h1 class="text-5xl font-extrabold md:text-2xl sm:text-2xl lg:text-5xl py-8">
        App Banco
    </h1>
    <a href="{{ route('cuentas.index') }}" class="text-lg text-blue-600 hover:underline">Cuentas</a>
</body>

</html>