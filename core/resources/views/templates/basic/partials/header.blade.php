<header class="header" id="header">
    <div class="container">
        <nav class="d-flex align-items-center">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="Site Logo"></a>
            <form action="#" autocomplete="off" class="search-box-wrapper">
                <button type="button" class="search-icon  d-block d-lg-none"><i class="las la-search"></i></button>
                <div class="search-field">
                    <input type="text" class="form--control" placeholder="Search to buy...">
                    <button type="submit" class="btn btn--base btn--sm">@lang('Search') <span class="icon"><i class="las la-search"></i></span></button>
                </div>
            </form>
            <div class="header__button ms-auto">
                <ul class="login-registration-list d-flex flex-wrap align-items-center">
                    @if(auth()->user())
                        <li class="login-registration-list__item">
                            <a href="{{ route('user.home') }}" class="login-registration-list__link"> <span class="icon"><i class="las la-home"></i> </span> <span class="d-lg-block d-none">Dashboard </span></a>
                        </li>
                        @else
                        <li class="login-registration-list__item">
                            <a href="{{ route('user.login') }}" class="login-registration-list__link"> <span class="icon"><i class="las la-user-circle"></i> </span> <span class="d-lg-block d-none">Login </span></a>
                        </li>
                    @endif

                    <li class="cart">
                        <a href="{{ route('cart.cart') }}" class="cart-icon">
                            <i class="las la-shopping-cart"></i>
                        </a>
                        <span class="cart-count">0</span>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
