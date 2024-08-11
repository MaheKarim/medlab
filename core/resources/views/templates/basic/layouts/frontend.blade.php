@extends($activeTemplate . 'layouts.app')

@section('app')
    @include($activeTemplate. 'partials.header')
    <!-- ==================== Header End Here ==================== -->

    <main>

        <!--========================== main Section Start ==========================-->
        <section class="main-section">
            <div class="container custom--container">
                <div class="row gy-4">
                    @include($activeTemplate. 'partials.sidebar')
                    @yield('content')
                </div>
            </div>
        </section>
        <!--========================== main Section End ==========================-->

    </main>
    <!-- Footer -->
    <!-- ==================== Footer Start Here ==================== -->
    @include($activeTemplate.'.partials.footer')
    <!-- ==================== Footer End Here ==================== -->
@endsection
