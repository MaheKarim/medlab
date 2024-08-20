@extends($activeTemplate . 'layouts.app')

@section('app')
    @include($activeTemplate. 'partials.header')
    <!-- ==================== Header End Here ==================== -->
    <main>
        <!--========================== main Section Start ==========================-->
                        @yield('content')
        <!--========================== main Section End ==========================-->
    </main>
    <!-- Footer -->
    <!-- ==================== Footer Start Here ==================== -->
    @include($activeTemplate.'partials.footer')
    <!-- ==================== Footer End Here ==================== -->
@endsection
