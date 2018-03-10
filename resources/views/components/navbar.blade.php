<nav class="navbar is-dark" role="navigation" aria-label="main dropdown navigation">
    <div class="container ">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ env('APP_URL') }}">
                <img src="{{ asset('img/logo-2.png') }}" alt="vCTF" style="width: 100%">
            </a>

            <div class="navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="navbar-menu">
            <div class="navbar-start">
                @include('components.navbar-item', ['items' => $left_nav->roots()])
            </div>
            <div class="navbar-end">
                {{--@php(dd($right_nav->roots()))--}}
                @include('components.navbar-item', ['items' => $right_nav->roots()])
            </div>
        </div>
    </div>
</nav>