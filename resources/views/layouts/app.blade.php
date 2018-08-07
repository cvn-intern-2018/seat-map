<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Cybozu VN</title>

    <!-- Jquery -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.min.css') }}">

    <!-- Style -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">


</head>
<body>
@include('header')


<div id="app">

    <main class="py-4">

        <div id="big-title">@yield('big-title','Cybozu VN')</div>
        <div class="container">

            @if (Session::has('notifications'))

                <div id="notifications" class="alert alert-info">
                    <strong>
                        @foreach (Session::get('notifications') as $notification)
                            {{ $notification }}<br>
                        @endforeach
                    </strong>
                </div>

            @endif



            @if ($errors->any())
                <div id="errors" class="alert alert-danger">
                    <strong>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </strong>
                </div>
            @endif
        </div>

        @yield('content')
    </main>
</div>

@include("footer")
</body>

@yield('scripts')
@if (Session::has('notifications'))
    <script src="{{ asset('js/notifications.js') }}"></script>
@endif
@if ($errors->any())
    <script src="{{ asset('js/errors.js') }}"></script>
@endif
</html>
