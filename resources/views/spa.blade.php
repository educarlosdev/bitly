<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/icon.png')}}">

    <meta name="title" content="Bitly - Encurtador de URL!">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    @vite('resources/css/app.css')
    <title>Bitly - Encurtador de URL!</title>
</head>
<body class="h-full">
<div id="app" class="h-screen"></div>

@vite('resources/js/app.js')
</body>
</html>
