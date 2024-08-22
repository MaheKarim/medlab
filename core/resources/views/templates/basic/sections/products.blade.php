@php
    $categories = \App\Models\Category::active()
        ->with([
            'products' => function ($query) {
                $query->active()->orderBy('name')->take(10);
            },
        ])
        ->orderBy('name')
        ->take(10)
        ->get()
        ->filter(function ($category) {
            return $category->products->isNotEmpty();
        });
@endphp
<div class="Product-wrapper pt-60">
    @foreach ($categories as $category)
        <div class="section-heading">
            <h5 class="section-heading__title">{{ __($category->name) }}</h5>
            <div class="section-heading__btn">
                <a href="{{ route('category.products', $category->slug) }}" class="btn btn--base"> @lang('View All') </a>
            </div>
        </div>
        <div class="swiper mySwiper py-3">
            <div class="swiper-wrapper">
                @foreach ($category->products as $product)
                    <div class="swiper-slide">
                        <div class="product-card">
                            <a href="{{ route('product.details', $product->id) }}" class="product-card__thumb">
                                <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}"
                                    alt="{{ $product->name }}">
                            </a>
                            <div class="product-card__content">
                                <p class="product-card__title">{{ __($product->name) }} <span
                                        class="product-size">{{ __($product->strength) }}</span></p>
                                <a href="{{ route('category.products', $product->category->slug) }}"
                                    class="product-card__text">{{ __(@$product->category->name) }}</a>
                                <p class="product-card__desc">{{ __(@$product->brand->name) }}</p>
                                <div class="product-card__bottom">
                                    <h6 class="product-card__price">
                                        @if ($product->discount > 0)
                                            {{ getMainPrice($product) }}
                                            <span class="old-price">{{ showAmount($product->price) }}</span>
                                        @else
                                            {{ showAmount($product->price) }}
                                        @endif
                                    </h6>
                                    <span class="add-cart cart-add-btn"
                                        data-product-id="{{ $product->id }}">@lang('Add To Cart')</span>
                                </div>
                            </div>
                            @if ($product->discount > 0)
                                <span class="product-offer">
                                    {{ showAmount($product->discount) }}
                                    @if ($product->discount_type == Status::FLAT_DISCOUNT)
                                        @lang('Flat')
                                    @else
                                        @lang('%')
                                    @endif
                                    @lang('Off')
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    @endforeach
</div>
@push('script')
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                type: "fraction",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                460: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                767: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1399: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        });
    </script>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/swiper.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/magnific-popup.js') }}"></script>
@endpush
