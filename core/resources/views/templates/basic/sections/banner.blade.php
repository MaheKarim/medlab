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
