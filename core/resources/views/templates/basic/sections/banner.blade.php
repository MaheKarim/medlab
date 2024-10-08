@php
    $bannerElement = getContent('banner.element', orderById: true);
@endphp
<div class="banner-slider">
    @foreach (@$bannerElement as $banner)
        <div>
            <div class="banner-slider__thumb">
                <img class="banner-thumb"
                    src="{{ frontendImage('banner', @$banner->data_values->slider_image, '1132x278') }}"
                    alt="bannerImage">
            </div>
        </div>
    @endforeach
</div>


@push('script')
    <script>
        $(".banner-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1000,
            speed: 1000,
            dots: false,
            pauseOnHover: true,
            arrows: false,
        });
    </script>
@endpush

@if (!app()->offsetExists('slick_asset'))
    @push('style-lib')
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    @endpush
    @push('script-lib')
        <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    @endpush
    @php app()->offsetSet('slick_asset',true) @endphp
@endif
