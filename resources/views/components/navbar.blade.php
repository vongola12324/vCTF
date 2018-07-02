<nav class="navbar is-dark" role="navigation" aria-label="main dropdown navigation">
    <div class="container ">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ env('APP_URL') }}">
                <img src="{{ asset('img/logo-2.png') }}" alt="vCTF" style="width: 100%">
            </a>

            <div role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="navbar-menu" id="navMenu">
            <div class="navbar-start">
                @include('components.navbar-item', ['items' => $left_nav->roots()])
            </div>
            <div class="navbar-end">
                @include('components.navbar-item', ['items' => $right_nav->roots()])
            </div>
        </div>
    </div>
</nav>