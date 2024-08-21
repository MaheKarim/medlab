<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title> {{ gs()->siteName(__($pageTitle)) }} </title>

    @include('partials.seo')

    <!-- Bootstrap -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">

    <!-- line awesome -->
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">

    <!-- Slick -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">


    <!-- Main css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.css')}}">
    @stack('style-lib')

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style')


    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ gs('base_color') }}">
</head>
@php echo loadExtension('google-analytics') @endphp

<body>
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
<div class="body-overlay"></div>

<div class="sidebar-overlay"></div>

<a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
@stack('fbComment')

@yield('app')

@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp
@if(($cookie->data_values->status == Status::ENABLE) && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card text-center hide">
        <div class="cookies-card__icon bg--base">
            <i class="las la-cookie-bite"></i>
        </div>
        <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
        <div class="cookies-card__btn mt-4">
            <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
        </div>
    </div>
    <!-- cookies dark version end -->
@endif

<!-- Jquery js -->
<script src="{{ asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

@stack('script-lib')
@php echo loadExtension('tawk-chat') @endphp

@include('partials.notify')
@if(gs('pn'))
    @include('partials.push_script')
@endif

<!-- Others JS  -->
<script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/swiper.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/magnific-popup.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

@stack('script')
<script>
    (function($) {
        "use strict";
        getCartTotal();
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

        let disableSubmission = false;
        $('.disableSubmission').on('submit',function(e){
            if (disableSubmission) {
                e.preventDefault()
            }else{
                disableSubmission = true;
            }
        });

        // Cart Related Code
        $(document).on('click', '.cart-add-btn', function (e) {
            var productId = $(this).data('product-id');
            var quantity = $(`[name="quantity"]`).val() || 1;
            var $this=$(this);

            let formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('cart.add') }}",
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $this.attr("disabled",true);
                },
                complete: function () {
                    $this.attr("disabled",false);
                },
                success: function (response) {
                    if (response.success) {
                        $('.cart-count').text(response.totalCartItem);
                        notify('success', response.message);
                    }else{
                        notify('error', response.message);
                    }
                },
            });
        });
        function getCartTotal() {
            $.ajax({
                url: "{{ route('cart.getCartTotal') }}",
                method: "get",
                dataType: "json",
                success: function (response) {
                    $('.cart-count').text(response);
                }
            });
        }
    })(jQuery);
</script>
</body>
</html>
