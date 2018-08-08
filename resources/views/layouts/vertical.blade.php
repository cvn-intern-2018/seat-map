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
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}"></script>
    <!-- Style -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">


</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-xs-3 col-sm-3 col-xl-3 col-lg-2"> @include('header_vertical')
            @yield('vertical')</div>

        <div class="col-md-9 col-xs-9 col-sm-9 col-xl-9 col-lg-10">
            <div id="app">

                <main class="py-4">
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
                    @yield('content')
                </main>
            </div>
        </div>


    </div>
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
