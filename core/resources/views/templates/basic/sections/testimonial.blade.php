@php
    $singleTestimonial = getContent('testimonial.content',true);
    $testimonialElement = getContent('testimonial.element', orderById: true);
@endphp
<section class="testimonials py-60">
    <div class="section-heading mb-3">
        <h5 class="section-heading__title"> {{ __(@$singleTestimonial->data_values->heading) }} </h5>
    </div>
    <div class="testimonial-slider">
        @foreach (@$testimonialElement as $testimonial)
            <div class="testimonials-card">
                <div class="testimonial-item">
                    <div class="testimonial-item__content">
                        <div class="testimonial-item__info">
                            <div class="testimonial-item__thumb">
                                <img
                                    src="{{ frontendImage('testimonial' , @$testimonial->data_values->image, '60x60') }}"
                                    class="fit-image" alt="@lang('Image')"/>
                            </div>
                            <div class="testimonial-item__details">
                                <h6 class="testimonial-item__name"> {{ __(@$testimonial->data_values->client_name) }} </h6>
                                <span
                                    class="testimonial-item__designation">{{ __(@$testimonial->data_values->address) }} </span>
                            </div>
                        </div>
                        <div class="testimonial-item__rating">
                            <ul class="rating-list">
                                @for ($i = 1; $i <= $testimonial->data_values->icon; $i++)
                                    <li class="rating-list__item"><i class="las la-star"></i></li>
                                @endfor
                            </ul>
                            <p class="text">{{ __(@$testimonial->data_values->date) }} </p>
                        </div>
                    </div>
                    <p class="testimonial-item__desc">
                        {{ __(@$testimonial->data_values->description) }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@push('script')
<script>
    $(".testimonial-slider").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        Infinity: true,
        autoplay: true,
        autoplaySpeed: 2000,
        speed: 1500,
        dots: false,
        pauseOnHover: true,
        arrows: true,
        prevArrow:
            '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
        nextArrow:
            '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    arrows: false,
                    slidesToShow: 1,
                    dots: true,
                },
            },
        ],
    });

</script>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
@endpush
