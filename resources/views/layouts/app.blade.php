<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>{{config('app.name','App Banco')}}</title>
</head>

@include('include.header')
<body class="text-lg font-medium font-sans text-black">
    <div class="p-4 min-h-screen">
        @yield('content')
    </div>
</body>
@include('include.footer')

</html>