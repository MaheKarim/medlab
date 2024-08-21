@php
    $bannerElement = getContent('banner.element', orderById: true);
@endphp
<div class="banner-slider">
    @foreach(@$bannerElement as $banner)
        <div>
            <div class="banner-slider__thumb">
                <img class="banner-thumb"
                     src="{{ frontendImage('banner', @$banner->data_values->slider_image, '1132x978') }}"
                     alt="bannerImage">
            </div>
        </div>
    @endforeach
</div>

@push('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
@endpush
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
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
@endpush
