@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="main-section">
        <div class="container custom--container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="Product-wrapper pt-50">
                        <div class="swiper mySwiper py-2">
                            <div class="swiper-wrapper">
                                @forelse($products as $product)
                                    <div class="swiper-slide">
                                        <div class="product-card">
                                            <a href="{{ route('product.details', $product->id) }}"
                                               class="product-card__thumb">
                                                <img
                                                    src="{{ getImage(getFilePath('product') . '/'. $product->image, getFileSize('product')) }}"
                                                    alt="{{ $product->name }}">
                                            </a>
                                            <div class="product-card__content">
                                                <p class="product-card__title">{{ __($product->name) }} <span
                                                        class="product-size">{{ __($product->strength) }}</span></p>
                                                <a href="{{ route('category.products', $product->category->slug) }}"
                                                   class="product-card__text">{{ @$product->category->name }}</a>
                                                <p class="product-card__desc">{{ __(@$product->brand->name) }}</p>
                                                <div class="product-card__bottom">
                                                    <h6 class="product-card__price">
                                                        @if ($product->discount > 0)
                                                            {{ getMainPrice($product) }}
                                                            <span
                                                                class="old-price">{{ showAmount($product->price) }}</span>
                                                        @else
                                                            {{ showAmount($product->price) }}
                                                        @endif
                                                    </h6>
                                                    <span class="add-cart cart-add-btn"
                                                          data-product-id="{{ $product->id }}">@lang('Add To Cart')</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center">
                                        <h5 class="text-center">@lang('No Products Found')</h5>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

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
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/swiper.js') }}"></script>
@endpush
