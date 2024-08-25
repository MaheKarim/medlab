<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ gs()->siteName(__($pageTitle)) }} </title>

    @include('partials.seo')

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style-lib')

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
    <div class="cookies-card text-center hide">
        <div class="cookies-card__icon bg--base">
            <i class="las la-cookie-bite"></i>
        </div>
        <p class="mt-4 cookies-card__content">{{ __($cookie->data_values->short_desc) }} <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
        <div class="cookies-card__btn mt-4">
            <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
        </div>
    </div>
@endif

<script src="{{ asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

@stack('script-lib')
@php echo loadExtension('tawk-chat') @endphp

@include('partials.notify')

@if(gs('pn'))
    @include('partials.push_script')
@endif

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

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {
            var elementType = $(element);
            if(elementType.attr('type') != 'checkbox'){
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            }

        });

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
    })(jQuery);
</script>
</body>
</html>
