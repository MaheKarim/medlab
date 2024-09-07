<header class="header" id="header">
    <div class="container">
        <nav class="d-flex align-items-center">
            <a class="navbar-brand logo" href="{{ route("home") }}"><img src="{{ siteLogo() }}" alt="Site Logo"></a>
            <form class="search-box-wrapper" action="{{ route("search") }}" autocomplete="off">
                <button class="search-icon d-block d-lg-none" type="button"><i class="las la-search"></i></button>
                <div class="search-field">
                    <input class="form--control" name="search" type="text" placeholder="@lang("Search products")...">
                    <button class="btn btn--base btn--sm" type="submit">@lang("Search") <span class="icon"><i
                               class="las la-search"></i></span>
                    </button>
                </div>
            </form>
            <div class="header__button ms-auto">
                <ul class="login-registration-list d-flex align-items-center flex-wrap">
                    @if (auth()->user())
                        <li class="login-registration-list__item">
                            <a class="login-registration-list__link" href="{{ route("user.home") }}"> <span
                                      class="icon"><i class="las la-home"></i> </span> <span
                                      class="d-lg-block d-none">@lang("Dashboard")</span></a>
                        </li>
                    @else
                        <li class="login-registration-list__item">
                            <a class="login-registration-list__link" href="{{ route("user.login") }}"> <span
                                      class="icon"><i class="las la-user-circle"></i> </span> <span
                                      class="d-lg-block d-none">@lang("Login")</span></a>
                        </li>
                    @endif
                    @php
                        if (auth()->check()) {
                            $userId = auth()->id();
                            $totalCart = App\Models\Cart::where("user_id", $userId)->count();
                        } else {
                            $sessionId = session()->get("session_id");
                            $totalCart = App\Models\Cart::where("session_id", $sessionId)->count();
                        }
                    @endphp
                    <li class="cart border-0">
                        <a class="cart-icon" href="{{ route("cart.cart") }}">
                            <i class="las la-shopping-cart"></i>
                        </a>
                        <span class="cart-count">{{ $totalCart }}</span>
                    </li>
                    @if (gs("multi_language"))
                        @php
                            $language = App\Models\Language::all();
                            $selectedLang = $language->where("code", session("lang"))->first();
                        @endphp
                        <div class="d-lg-block d-none">
                            <div class="dropdown-lang dropdown d-block mt-0">
                                <a class="language-btn dropdown-toggle" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <img class="flag" src="{{ getImage(getFilePath("language") . "/" . @$selectedLang->image, getFileSize("language")) }}" alt="us">
                                    <span class="language-text text-white">{{ __(@$selectedLang->name) }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($language as $lang)
                                        <li>
                                            <a href="{{ route("lang", $lang->code) }}">
                                                <img class="flag" src="{{ getImage(getFilePath("language") . "/" . @$lang->image, getFileSize("language")) }}" alt="@lang("image")">
                                                {{ __(@$lang->name) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <button class="navbar-toggler header-button">
                        <span class="bar-icon"><i class="las la-bars"></i></span>
                    </button>
                </ul>
            </div>
        </nav>
    </div>
</header>
