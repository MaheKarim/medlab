@php
    $categoryData = getContent('categories.content',orderById: true)->first();
@endphp

<div class="product-category">
    <div class="section-heading">
        <h5 class="section-heading__title"> {{ __(@$categoryData->data_values->heading) }} </h5>
        <div class="section-heading__btn">
            <a href="{{ route('all.category') }}" class="btn btn--base ">@lang('View All')</a>
        </div>
    </div>
    <div class="product-slider mt-2">
        @foreach(@$sidebarCategories as $category)
            <div>
                <a href="#" class="product-item">
                    <div class="product-item__thumb">
                        <img src="{{ getImage(getFilePath('category') .'/' . $category->image, '50x50') }}" alt="Category Image">
                    </div>
                    <p class="product-item__text"> {{ __($category->name) }} </p>
                </a>
            </div>
        @endforeach
    </div>
</div>

@push('script')
    <script>
    $('.product-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplaySpeed: 1000,
      pauseOnHover: true,
      speed: 1000,
      dots: false,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow: 3,
          }
        },

        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 375,
          settings: {
            slidesToShow: 1
          }
        }
      ]
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
