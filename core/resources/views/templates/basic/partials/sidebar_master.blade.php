<!-- ====================== Sidebar menu Start ========================= -->
<div class="sidebar-menu">
    <div class="sidebar-menu__inner">
        <span class="sidebar-menu__close d-xl-none d-block"><i class="fas fa-times"></i></span>
        <!-- ========= User Profile Info Start ================ -->
        <div class="user-profile-info">
            <span class="user-profile-info__thumb flex-center">
                <img src="{{ getImage(getFilePath('userProfile'). '/'. $user->image, getFileSize('userProfile')) }}" alt="@lang('User Image')">
            </span>
            <div class="user-profile-info__content">
                <h6 class="user-profile-info__name"> {{ Auth::user()->fullName }} </h6>
                <p class="user-profile-info__desc"> {{ Auth::user()->email }} </p>
            </div>
        </div>

        <!-- ========= User Profile Info End ================ -->
        <!-- ========= Sidebar Menu Start ================ -->
        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item {{ menuActive('user.home') }}">
                <a class="sidebar-menu-list__link" href="{{ route("user.home") }}">
                    <span class="icon"><i class="las la-home"></i></span>
                    <span class="text">@lang('Dashboard')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('user.order.history') }}">
                <a class="sidebar-menu-list__link" href="{{ route("user.order.history") }}">
                <span class="icon">
                    <i class="las la-list"></i>
                </span>
                    <span class="text"> @lang('Order History') </span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{ menuActive('user.transactions') }}">
                <a class="sidebar-menu-list__link" href="{{ route("user.transactions") }}">
                    <span class="icon">
                        <i class="las la-layer-group"></i>
                    </span>
                    <span class="text"> @lang('Transactions Log')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{ menuActive('ticket.index') }}">
                <a class="sidebar-menu-list__link" href="{{ route("ticket.index") }}">
                    <span class="icon"><i class="las la-clipboard-list"></i></span>
                    <span class="text">@lang('Support Tickets')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('ticket.open') }}">
                <a class="sidebar-menu-list__link" href="{{ route("ticket.open") }}">
                    <span class="icon"><i class="la la-ticket"></i></span>
                    <span class="text">@lang('Create Ticket')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('user.profile.setting') }}">
                <a class="sidebar-menu-list__link" href="{{ route("user.profile.setting") }}">
                    <span class="icon"><i class="las la-user-alt"></i></span>
                    <span class="text"> @lang('My Profile') </span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('user.change.password') }}">
                <a class="sidebar-menu-list__link" href="{{ route("user.change.password") }}">
                    <span class="icon"><i class="las la-shield-alt"></i></span>
                    <span class="text">@lang("Change Password")</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link logout" href="{{ route("user.logout") }}">
                    <span class="icon"><i class="la la-sign-out"></i></span>
                    <span class="text">@lang('Log Out')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                @include($activeTemplate . 'partials.language')
            </li>
        </ul>
    </div>
</div>
