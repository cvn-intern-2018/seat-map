<header>
    <p>This is the header</p>
    <nav>
        <ul class="main-menu">
            <li class="menu-item"><a href="{{route('home')}}">Home</a></li>
            @isset($add_menu)
            {{ $add_menu }}
            @endisset
        </ul>
    </nav>
</header>