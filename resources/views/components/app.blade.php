<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ $description ?? ''}}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ $canonical ?? '' }}">
    <link rel="shortcut icon" type="/images/x-icon" href="/favicon.ico">
    <link rel="bookmark" type="images/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.ico">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{ $style ?? '' }}
    <title>{{ $title ?? env('APP_NAME') }}</title>
    @livewireStyles

    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireScripts
</head>
<body>
    {{ $header ?? '' }}
    {{ $main ?? '' }}
    {{ $footer ?? '' }}
    {{ $script ?? '' }}
</body>
</html>