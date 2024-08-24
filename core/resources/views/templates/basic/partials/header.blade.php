<header class="header" id="header">
    <div class="container">
        <nav class="d-flex align-items-center">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="Site Logo"></a>
            <form action="{{ route('search') }}" autocomplete="off" class="search-box-wrapper">
                <button type="button" class="search-icon  d-block d-lg-none"><i class="las la-search"></i></button>
                <div class="search-field">
                    <input type="text" class="form--control" name="search" placeholder="@lang('Search products')...">
                    <button type="submit" class="btn btn--base btn--sm">@lang('Search') <span class="icon"><i class="las la-search"></i></span></button>
                </div>
            </form>
            <div class="header__button ms-auto">
                <ul class="login-registration-list d-flex flex-wrap align-items-center">
                    @if (auth()->user())
                        <li class="login-registration-list__item">
                            <a href="{{ route('user.home') }}" class="login-registration-list__link"> <span
                                    class="icon"><i class="las la-home"></i> </span> <span
                                    class="d-lg-block d-none">@lang('Dashboard')</span></a>
                        </li>
                    @else
                        <li class="login-registration-list__item">
                            <a href="{{ route('user.login') }}" class="login-registration-list__link"> <span
                                    class="icon"><i class="las la-user-circle"></i> </span> <span
                                    class="d-lg-block d-none">@lang('Login')</span></a>
                        </li>
                    @endif
                        @php
                            if (auth()->check()) {
                                $userId = auth()->id();
                                $totalCart = App\Models\Cart::where('user_id', $userId)->count();
                            } else {
                               $sessionId = session()->get('session_id');
                               $totalCart = App\Models\Cart::where('session_id', $sessionId)->count();
                            }
                        @endphp
                    <li class="cart">
                        <a href="{{ route('cart.cart') }}" class="cart-icon">
                            <i class="las la-shopping-cart"></i>
                        </a>
                        <span class="cart-count">{{ $totalCart }}</span>
                    </li>
                    @if (gs('multi_language'))
                        @php
                            $language = App\Models\Language::all();
                            $selectedLang = $language->where('code', session('lang'))->first();
                        @endphp
                        <div class="dropdown-lang dropdown mt-0 d-block">
                            <a href="#" class="language-btn dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img class="flag"
                                    src="{{ getImage(getFilePath('language') . '/' . @$selectedLang->image, getFileSize('language')) }}"
                                    alt="us">
                                <span class="language-text text-white">{{ __(@$selectedLang->name) }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($language as $lang)
                                    <li>
                                        <a href="{{ route('lang', $lang->code) }}">
                                            <img class="flag"
                                                src="{{ getImage(getFilePath('language') . '/' . @$lang->image, getFileSize('language')) }}"
                                                alt="@lang('image')">
                                            {{ __(@$lang->name) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
