<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>
    <!-- Jquery -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" ></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.min.css') }}" >
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}" ></script>

    @yield("scripts")
</head>
<body>
    @include("header")
    <main>
        @yield("main")
    </main>
    @include("footer")
</body>
</html>