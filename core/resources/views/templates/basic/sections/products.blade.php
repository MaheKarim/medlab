@php
    $categories = \App\Models\Category::active()
        ->with(['products' => function($query) {
            $query->active()->orderBy('name')->take(10);
        }])
        ->orderBy('name')
        ->take(10)
        ->get()
        ->filter(function($category) {
            return $category->products->isNotEmpty();
        });
@endphp
<div class="Product-wrapper pt-60">
    @foreach($categories as $category)
        <div class="section-heading">
            <h5 class="section-heading__title">{{ $category->name }}</h5>
            <div class="section-heading__btn">
                <a href="{{ route('category.products', $category->slug) }}" class="btn btn--base">View all</a>
            </div>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($category->products as $product)
                    <div class="swiper-slide">
                        <div class="product-card">
{{--                            <a href="{{ route('product.details', $product->id) }}" class="product-card__thumb">--}}
                            <a href="{{ route('product.details', $product->id) }}" class="product-card__thumb">
                                <img src="{{ getImage(getFilePath('product') . '/'. $product->image, getFileSize('product')) }}" alt="{{ $product->name }}">
                            </a>
                            <div class="product-card__content">
                                <p class="product-card__title">{{ $product->name }} <span class="product-size">{{ $product->strength }}</span></p>
{{--                                <a href="{{ route('product.details', $product->id) }}" class="product-card__text">{{ $product->category->name }}</a>--}}
                                <a href="{{ route('category.products', $product->category->slug) }}" class="product-card__text">{{ @$product->category->name }}</a>
                                <p class="product-card__desc">{{ @$product->brand->name }}</p>
                                <div class="product-card__bottom">
                                    <h6 class="product-card__price">
                                        @if ($product->discount > 0)
                                            {{ getMainPrice($product) }}$
                                            <span class="old-price">{{ getAmount($product->price) }}</span>
                                        @else
                                            {{ getAmount($product->price) }}$
                                        @endif
                                    </h6>
{{--                                    <h6 class="product-card__price">{{ $product->price }}$ <span class="old-price">{{ $product->old_price }}$</span></h6>--}}
                                    <span class="add-cart">Add to cart</span>
                                </div>
                            </div>
                            @if($product->discount > 0)
                                <span class="product-offer">
                                            {{ getAmount($product->discount) }}
                                    @if($product->discount_type == \App\Constants\Status::FLAT_DISCOUNT)
                                        @lang('Flat')
                                    @else
                                        @lang('%')
                                    @endif
                                            Off
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
