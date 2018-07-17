<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body>
    @component('header')
        @slot('add_menu')
        @foreach ($add_menu as $menu)
        <li class="menu-item"><a href="{{$menu['link']}}">{{$menu['text']}}</a></li>
        @endforeach
        @endslot
    @endcomponent
    @yield('main')
    @include('footer')
</body>
</html>