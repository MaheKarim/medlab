<!-- Header -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->
    <title> {{ gs()->siteName(__($pageTitle)) }} </title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <!-- Slick -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">

    <!-- line awesome -->
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    @stack('style-lib')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}">
</head>
@php echo loadExtension('google-analytics') @endphp

<body>
<!--==================== Preloader Start ====================-->
<div class="preloader-wrapper">
    <div class="preloader">
        <div class="wrapper">
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
        </div>
    </div>
</div>
<!--==================== Preloader End ====================-->
<!--==================== Overlay Start ====================-->
<div class="body-overlay"></div>
<!--==================== Overlay End ====================-->

<!--==================== Sidebar Overlay End ====================-->
<div class="sidebar-overlay"></div>
<!--==================== Sidebar Overlay End ====================-->

<!-- ==================== Scroll to Top End Here ==================== -->
<a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
<!-- ==================== Scroll to Top End Here ==================== -->
<!-- ==================== Header Start Here ==================== -->

      @yield('app')


<!-- Jquery js -->
<script src="{{ asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/global/js/slick.min.js') }}"></script>

@stack('script-lib')
@php echo loadExtension('tawk-chat') @endphp

    <!-- Others JS  -->
<script src="{{ asset($activeTemplateTrue . 'js/swiper.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/magnific-popup.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

@stack('script')
<script>
    (function($) {
        "use strict";
        $(".langSel").on("click", function() {
            window.location.href = "{{ route('home') }}/change/" + $(this).data('lang_code');
        });

        $('.policy').on('click', function() {
            $.get('{{ route('cookie.accept') }}', function(response) {
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function() {
            $('.cookies-card').removeClass('hide')
        }, 2000);
    })(jQuery);
</script>

</body>
</html>
