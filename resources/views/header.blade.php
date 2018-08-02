<header>

    <div class="container-fluid">
        <!-- Second navbar for categories -->
        <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"> <img src="{{asset('images/logo.png')}}" width=130></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->

                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">

                        @guest
                            <li>
                                <a class="btn btn-default btn-outline btn-circle collapsed" href="/login">Login</a>
                            </li>
                        @else

                            <li class="@yield('home-active')"><a href="#">Home</a></li>
                            <li><a href="" class="@yield('groups-active')">Groups</a></li>
                            <li><a href="" class="@yield('users-active')">Users</a></li>

                            <li>


                                <a class="btn btn-default btn-outline btn-circle collapsed" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>

                            </li>

                        @endguest
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->
    </div><!-- /.container-fluid -->


</header>