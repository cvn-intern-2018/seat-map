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
<div  class="col-md-2 full-size" > @include('header2')</div>

<div  class="col-md-10 full-size">
    <div id="app">

        <main class="py-4">

            <div id="big-title">@yield('big-title','Cybozu VN')</div>


                @if (Session::has('notifications'))
                    <div class="alert alert-success">
                        <ul>
                            @foreach (Session::get('notifications') as $notification)

                                <li>{{ $notification }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif



                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif





            @yield('content')
        </main>
    </div>
</div>




    </div>
</div>


</body>
@yield('scripts')
</html>