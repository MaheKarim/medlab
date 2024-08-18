@extends($activeTemplate . 'layouts.frontend')
@section('content')
        <div class="account section-bg py-60">
            <div class="row justify-content-center custom--container">
                <div class="swiper-slide">
                    @foreach($products as $product)
                        <div class="product-card">
                            <a href="{{ route('product.details', $product->id) }}" class="product-card__thumb">
                                <img src="{{ getImage(getFilePath('product') . '/'. $product->image, getFileSize('product')) }}" alt="{{ $product->name }}">
                            </a>
                            <div class="product-card__content">
                                <p class="product-card__title">{{ __($product->name) }} <span class="product-size">{{ __($product->strength) }}</span></p>
                                <a href="{{ route('category.products', $product->category->slug) }}" class="product-card__text">{{ @$product->category->name }}</a>
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
                                    <span class="add-cart cart-add-btn" data-product-id="{{ $product->id }}">@lang('Add To Cart')</span>
                                </div>
                            </div>
                            @if($product->discount > 0)
                                <span class="product-offer">
                                            {{ showAmount($product->discount) }}
                                    @if($product->discount_type == \App\Constants\Status::FLAT_DISCOUNT)
                                        @lang('Flat')
                                    @else
                                        @lang('%')
                                    @endif
                                            Off
                                        </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection
