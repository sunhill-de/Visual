<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $sitename }} - @yield('title')</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/sunhill.css') }}">  
		@stack('css')
		@stack('js')
    </head>
    <body>
     @yield('body')
    </body>
</html>
