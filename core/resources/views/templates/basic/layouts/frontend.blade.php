@extends($activeTemplate . 'layouts.app')

@section('app')
    @include($activeTemplate. 'partials.header')
    <!-- ==================== Header End Here ==================== -->
    <main>

        <!--========================== main Section Start ==========================-->
                        @yield('content')
        <!--========================== main Section End ==========================-->
        @include($activeTemplate. 'partials.wishlist')

    </main>
    <!-- Footer -->
    <!-- ==================== Footer Start Here ==================== -->
    @include($activeTemplate.'.partials.footer')
    <!-- ==================== Footer End Here ==================== -->
@endsection
